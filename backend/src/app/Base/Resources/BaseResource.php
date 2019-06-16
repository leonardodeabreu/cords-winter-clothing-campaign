<?php

namespace App\Base\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BaseResource extends Resource
{
    /**
     * @var array
     */
    protected $withoutFields = [];

    /**
     * @param string     $key
     * @param array|null $replace
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    protected static function trans(string $key, ?array $replace = [])
    {
        return trans($key, $replace, config('app.resource_locale'));
    }

    /**
     * Set the keys that are supposed to be filtered out.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    /**
     * Remove the filtered keys.
     *
     * @param $array
     *
     * @return array
     */
    protected function filterFields($array): array
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
