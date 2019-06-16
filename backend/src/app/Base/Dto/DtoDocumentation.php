<?php

namespace App\Base\Dto;


trait DtoDocumentation
{
    private $types
        = [
            'integer',
            'numeric',
            'boolean',
            'string',
            'date',
            'array',
        ];

    /**
     * @return array
     */
    public function getDocumentation(): array
    {
        $return = [
            'type'       => 'object',
            'properties' => []
        ];
        foreach ($this->items as $key => $value) {
            $return['properties'][$key] = $this->makeDocument($key, $value);
        }

        return $return;
    }

    /**
     * @param string $attribute
     * @param        $value
     *
     * @return array
     */
    private final function makeDocument(string $attribute, $value): array 
    {
        if (isset($this->subtypes[$attribute])) {
            /** @var BaseDto $subDto */
            $subDto  = new $this->subtypes[$attribute];
            $subDocs = $subDto->getDocumentation();
            if (is_array($value)) {
                return [
                    'type'  => 'array',
                    'items' => $subDocs
                ];
            }

            return $subDocs;
        }

        $ruleTypeProperties = $this->getRuleTypeProperties($attribute);
        if ($ruleTypeProperties) {
            return $ruleTypeProperties;
        }

        return [];
    }

    /**
     * @param string $attribute
     *
     * @return bool|array
     */
    public function getRuleTypeProperties(string $attribute)
    {
        if (isset($this->rules[$attribute])) {
            $rule      = $this->rules[$attribute];
            $ruleItems = explode('|', $rule);
            $ruleType  = 'string';
            foreach ($this->types as $type) {
                if (in_array($type, $ruleItems)) {
                    $ruleType = $type;
                    break;
                }
            }

            return [
                'type'        => $ruleType,
                'required'    => in_array('required', $ruleItems),
                'description' => 'Validation rules: ' . $rule
            ];
        }

        return false;
    }
}
