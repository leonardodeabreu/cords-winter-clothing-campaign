<?php

namespace App\Base\Dto;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;

abstract class BaseDto extends Collection
{
    use DtoDocumentation;

    /**
     * DTO-s fields default date and datetime formats
     */
    const DATE_FORMAT = 'Y-m-d';
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * DTO fields
     *
     * Provide default field values in concrete class items array.
     *
     *  - For a subtype, the field value must be `null`.
     *  - For an array of subtypes, the field value must be `[]`.
     *
     * @var array
     */
    protected $items = [];

    /**
     * DTO base fields
     *
     * Merge default field values in concrete class items array.
     *
     *  - For a subtype, the field value must be `null`.
     *  - For an array of subtypes, the field value must be `[]`.
     *
     * @var array
     */
    private $base_items
        = [
            'limit',
            'paginate',
            'page'
        ];

    /**
     * Field-to-subtype map
     *
     * ```
     * [
     *   'company' => CompanyDto::class,
     *   'articles' => ArticleDto::class,
     * ]
     * ```
     *
     * @var array
     */
    protected $subtypes = [];

    /**
     * Laravel Validation compatible rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Turn validation on/off
     *
     * @var bool
     */
    protected $validation = true;

    /**
     * BaseDto constructor.
     */
    public function __construct()
    {
        $this->items = array_merge($this->items, $this->base_items);

        parent::__construct($this->items);
    }

    /**
     * Get subtype class
     *
     * Return null if subtype is not defined.
     *
     * @param string $field
     *
     * @return string|bool
     */
    public function getSubtype(string $field)
    {
        return $this->subtypes[$field] ?? false;
    }

    /**
     * Populate and validate a DTO and sub-DTO-s from data array
     *
     * - Can be used in controllers, to fill from Request::all()
     * - Only sets values for keys that are predefined in DTO
     *
     * @param array $data
     *
     * @return $this
     * @throws \Exception
     */
    public function populateFromArray(array $data): BaseDto
    {
        $this->populate($data);

        $this->validation && $this->validate();

        $this->items = collect($this->items)
            ->filter(function ($value, $key) {
                return !is_numeric($key);
            })
            ->map(function ($value, $key) {
                return $this->filterValue($key, $value);
            })->all();

        return $this;
    }

    public function populate(array $data): void
    {
        $data = array_intersect_key($data, array_flip($this->toArray()));
        collect($data)
            ->filter(function ($value) {
                return !in_array($value, [null, ''], true);
            })
            ->map(function ($value, $key) {
                if (is_array($value) && $this->getSubtype($key)) {
                    $value = $this->populateSubtypeFromArray($key, $value);
                }
                $this[$key] = $value;
                $key        = array_search($key, $this->items);
                if ($key !== false) {
                    unset($this->items[$key]);
                }
            });
    }

    /**
     * @param string $attribute
     * @param        $value
     *
     * @return mixed
     */
    protected final function filterValue(string $attribute, $value)
    {
        if ($this->getRuleTypeProperties($attribute)['type'] === 'boolean') {
            return boolval($value);
        }

        if ($this->getRuleTypeProperties($attribute)['type'] === 'string') {
            return trim(filter_var($value, FILTER_SANITIZE_STRING));
        }

        if ($this->getRuleTypeProperties($attribute)['type'] === 'integer') {
            return intval($value);
        }

        return $value;
    }

    /**
     * Populate subtype(s) from array, and return the toArray() of subtype(s)
     *
     * Subtypes in DTO-s can be defined as an array of subtype objects, or as one subtype object.
     *
     * This method detects if DTO subtype is an array of subtypes, or just one subtype.
     * After populating the subtype(s) from array(s), the toArray() of one subtype DTO is returned,
     * or an array of subtype DTO-s toArray()-s.
     *
     * @param string $key
     * @param array  $value
     *
     * @return array
     */
    private function populateSubtypeFromArray(string $key, array $value): array
    {
        if (is_array($this[$key])) {
            return collect($value)->map(function (array $values) use ($key) {
                return (new $this->subtypes[$key])->populateFromArray($values)->toArray();
            })->toArray();
        }

        return (new $this->subtypes[$key])->populateFromArray($value)->toArray();
    }

    /**
     * DTO factory method
     *
     * Create new DTO instances, and populate them depending on $source type.
     *
     * Accepts:
     *
     *   - Array of data - return and populate a DTO instance
     *
     * Provide default return value, an empty Collection instance, to accommodate
     * for sub-DTO's generation, with `$this['company'] = CompanyDto::from($page->companies)->toArray();`.
     * In this case, the `from` call always returns an instance of Collection (Collection of DTO-s,
     * one DTO, or an empty Collection), which can always be converted to an array for the subtype value.
     *
     * @param array      $source
     *
     * @param null|array $rules
     *
     * @return $this
     */
    public static function fromArray(array $source, ?array $rules = [])
    {
        if (!empty($rules)) {
            return (new static)->setRules($rules)->populateFromArray($source);
        }

        return (new static)->populateFromArray($source);
    }

    /**
     * Validate DTO by rules defined in $rules
     *
     * @return Validator
     */
    public function validate(): Validator
    {
        $validator = \Validator::make($this->items, $this->rules);

        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }

        return $validator;
    }

    /**
     * Throw validation exception
     *
     * Include list of failures for each field, in machine-parseable format.
     *
     * @param Validator $validator
     */
    protected function throwValidationException(Validator $validator): void
    {
        $message = (method_exists($this, 'message'))
            ? $this->container->call([$this, 'message'])
            : sprintf(
                'The given data was invalid in DTO Validation failed for %s.',
                get_called_class()
            );

        throw new HttpResponseException(response()->json([
            'message' => $message,
            'errors'  => $validator->errors(),
        ], 422));
    }

    /**
     * @param array $rules
     *
     * @return BaseDto
     */
    public final function setRules(array $rules): BaseDto
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param bool $validation
     *
     * @return BaseDto
     */
    public function setValidation(bool $validation): BaseDto
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getLimit(): ?int
    {
        return array_get($this->items, 'limit', null);
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->items['limit'] = $this->filterValue('limit', $limit);
    }

    /**
     * @return null|int
     */
    public function getPaginate(): ?int
    {
        return array_get($this->items, 'paginate', null);
    }

    /**
     * @param int $paginate
     */
    public function setPaginate(int $paginate): void
    {
        $this->items['paginate'] = $this->filterValue('paginate', $paginate);
    }

    /**
     * @return null|int
     */
    public function getPage(): ?int
    {
        return array_get($this->items, 'page', null);
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->items['page'] = $this->filterValue('page', $page);
    }
}
