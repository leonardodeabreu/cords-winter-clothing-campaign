<?php

namespace App\Api\Players\Imports;

use App\Api\Players\Models\PlayerModel;
use Maatwebsite\Excel\Concerns\ToModel;

class PlayerImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return PlayerModel|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     */
    public function model(array $row)
    {
        return new PlayerModel([
            'name' => $row[0],
            'rfid' => $row[1],
        ]);
    }
}
