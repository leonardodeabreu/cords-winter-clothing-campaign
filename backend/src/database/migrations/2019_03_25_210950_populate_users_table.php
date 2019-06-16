<?php

use Illuminate\Database\Migrations\Migration;
use App\Api\User\Repositories\UserRepository;

class PopulateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        $user = new UserRepository();
        if (!$user->count()) {
            $user->create([
                'name'           => 'Administrador',
                'email'          => 'cords@db1.com.br',
                'active'         => 1,
                'remember_token' => str_random(10),
            ]);
        }
    }
}
