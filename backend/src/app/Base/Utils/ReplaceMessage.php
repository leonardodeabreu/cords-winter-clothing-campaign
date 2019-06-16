<?php

namespace App\Base\Utils;

use App\Base\Enums\ResponseEnum;

class ReplaceMessage
{
    /**
     * Replace relationship for the model.
     *
     * @param string $relationship
     *
     * @return string
     */
    public static final function replaceHasRelationship(string $relationship): string
    {
        return str_replace(':relationship', trans("model.{$relationship}"),
            trans(ResponseEnum::FAILED_HAS_RELATIONSHIP));
    }
}
