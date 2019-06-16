<?php

namespace App\Base\Validations\Rules;

use Illuminate\Contracts\Validation\Rule;
use UrlSigner;

class Lowercase implements Rule
{
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
        return strtolower($value) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.custom.casesensitive.lowercase');
    }
}
