<?php

namespace App\Base\Validations\Rules;

use App\Base\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Rule;

class NotIn implements Rule
{
    /**
     * @var string
     */
    private $target;

    /**
     * @var array|null
     */
    private $notIn;

    /**
     * @var string
     */
    private $attribute;

    /**
     * Create a new rule instance.
     *
     * @param string     $target
     * @param array|null $notIn
     */
    public function __construct(string $target, array $notIn = null)
    {
        $this->target = $target;
        $this->notIn  = $notIn;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = BaseRequest::parseAttribute($attribute);
        $this->target    = BaseRequest::parseAttribute($this->target);

        if (is_array($value) && count(array_intersect($value, $this->notIn)) > 0) {
            return false;
        }

        if (in_array($value, $this->notIn)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return str_replace(
            [':attribute', ':other'],
            [trans("attribute.{$this->attribute}"), trans("attribute.{$this->target}")],
            trans('validation.custom.not_in.array')
        );
    }
}
