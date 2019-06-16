<?php

namespace App\Base\Validations;


use App;
use App\Base\Requests\BaseRequest;
use DB;
use Illuminate\Validation\Validator;
use App\Base\Validations\Rules\{Protocol as ProtocolRule, District as DistrictRule};

class BaseValidation extends Validator
{
    /**
     * Validation CPF
     *
     * @param string $attribute
     * @param string $value
     *
     * @return boolean
     */
    protected function validateCpf(string $attribute, string $value)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $value);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validation CNPJ
     *
     * @param string $attribute
     * @param string $value
     *
     * @return boolean
     */
    protected function validateCnpj(string $attribute, string $value)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $value);
        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj{$i} * $j;
            $j   = ($j == 2) ? 9 : $j - 1;
        }
        $rest = $sum % 11;
        if ($cnpj{12} != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj{$i} * $j;
            $j   = ($j == 2) ? 9 : $j - 1;
        }
        $rest = $sum % 11;

        if ($cnpj{13} != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        return true;
    }

    /**
     * Validation iUnique
     *
     * @param string $attribute
     * @param string $value
     * @param array  $parameters
     *
     * @return boolean
     */
    protected function validateIunique(string $attribute, string $value, array $parameters)
    {
        if (count($parameters) === 1) {
            $parameters[1] = $attribute;
        }
        $query  = DB::table($parameters[0]);
        $column = $query->getGrammar()->wrap($parameters[1]);

        return !$query
            ->whereRaw("lower({$column}) = lower(?)", [$value])
            ->count();
    }
}
