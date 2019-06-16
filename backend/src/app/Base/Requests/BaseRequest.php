<?php

namespace App\Base\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * @var array
     */
    protected $additionalRules = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get keys of rules
     *
     * @return array
     */
    public static final function getKeys(): array
    {
        return collect((new static())->rules())->keys()->all();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        $attributes      = array_merge($this->additionalRules, self::getKeys());
        $parseAttributes = [];
        foreach ($attributes as $attribute) {
            $parseAttributes[$attribute] = trans("attribute.{$this->parseAttribute($attribute)}");
        }

        return $parseAttributes;
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    public static final function parseAttribute(string $attribute): string
    {
        if (strrchr($attribute, ".")) {
            return substr(strrchr($attribute, "."), 1);
        }

        return $attribute;
    }
}
