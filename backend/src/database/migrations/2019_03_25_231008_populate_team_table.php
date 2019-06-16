<?php

use Illuminate\Database\Migrations\Migration;
use App\Api\Team\Repositories\TeamRepository;

class PopulateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        $data = $this->getData();

        DB::table('teams')->insert($data);
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            [
                'name'    => 'Capitão América',
                'coach_1' => 'Jônatas',
                'coach_2' => 'Mayara',
            ],
            [
                'name'    => 'Hulk',
                'coach_1' => 'Ana Letícia',
                'coach_2' => 'Leonardo',
            ],
            [
                'name'    => 'Capitã Marvel',
                'coach_1' => 'Bailão',
                'coach_2' => 'Lucas',
            ],
            [
                'name'    => 'Pantera Negra',
                'coach_1' => 'Andressa',
                'coach_2' => 'Raul',
            ],
            [
                'name'    => 'Thor',
                'coach_1' => 'Maicon',
                'coach_2' => 'Vinícius',
            ],
            [
                'name'    => 'Homem de Ferro',
                'coach_1' => 'Matheus',
                'coach_2' => 'Carol',
            ],
        ];
    }
}
