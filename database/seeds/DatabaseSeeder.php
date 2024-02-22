<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'Guest',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('excavacions')->insert([
            'codi' => '120/17',
            'nom' => 'Carrer Regomir, 6',
            'poblacio' => 'Barcelona, el Barcelonès',
        ]);

        DB::table('ues')->insert([
            'codi' => '001',
            'excavacio_id' => 1,
            'sector' => 'Sector001',
            'definicio' => 'Estructura',
            'descripcio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'interpretacio' => 'Parament exterior de la muralla baix imperial',
            'cronologia' => 'Darrer quart del segle III - inicis del segle IV dC'
        ]);

        DB::table('ues')->insert([
            'codi' => '002',
            'excavacio_id' => 1,
            'sector' => 'Sector001',
            'definicio' => 'Estructura',
            'descripcio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'interpretacio' => 'Rebliment interior de la muralla baix imperial UE 01',
            'cronologia' => 'Darrer quart del segle III - inicis del segle IV dC'
        ]);

        DB::table('ues')->insert([
            'codi' => '003',
            'excavacio_id' => 1,
            'sector' => 'Sector001',
            'definicio' => 'Estructura',
            'descripcio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'interpretacio' => 'Pou de registre',
            'cronologia' => 'Segona metitat del segloe XIX'
        ]);

        DB::table('ues')->insert([
            'codi' => '004',
            'excavacio_id' => 1,
            'sector' => 'Sector001',
            'definicio' => 'Estructura',
            'descripcio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'interpretacio' => 'Mur de funcionalitat indeterminada',
            'cronologia' => 'Época moderna'
        ]);

        DB::table('ues')->insert([
            'codi' => '005',
            'excavacio_id' => 1,
            'sector' => 'Sector001',
            'definicio' => 'Estrat',
            'descripcio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'interpretacio' => 'Rebliment de rasa de construcció de l\'edifici',
            'cronologia' => 'Segle XIX'
        ]);

        DB::table('tipus_relacions')->insert([
            ['nom' => 'Igual a',
                'invers' => 1],
            ['nom' => 'Cobreix',
                'invers' => 3],
            ['nom' => 'Cobert per',
                'invers' => 2],
            ['nom' => 'Farceix',
                'invers' => 5],
            ['nom' => 'Farcit per',
                'invers' => 4],
            ['nom' => 'Talla',
                'invers' => 7],
            ['nom' => 'Tallat per',
                'invers' => 6],
            ['nom' => 'Recolza',
                'invers' => 9],
            ['nom' => 'Se li recolza',
                'invers' => 8],
            ['nom' => 'Es lliura a',
                'invers' => 11],
            ['nom' => 'Se li lliura',
                'invers' => 10],
            ['nom' => 'Solidari de',
                'invers' => 12],
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 1,
            'tipus_relacio_id' => 2,
            'ue_desti_id' => 2,
            'inversa' => 2
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 2,
            'tipus_relacio_id' => 3,
            'ue_desti_id' => 1,
            'inversa' => 1
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 1,
            'tipus_relacio_id' => 4,
            'ue_desti_id' => 3,
            'inversa' => 4
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 3,
            'tipus_relacio_id' => 5,
            'ue_desti_id' => 1,
            'inversa' => 3
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 1,
            'tipus_relacio_id' => 6,
            'ue_desti_id' => 4,
            'inversa' => 6
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 4,
            'tipus_relacio_id' => 7,
            'ue_desti_id' => 1,
            'inversa' => 5
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 1,
            'tipus_relacio_id' => 8,
            'ue_desti_id' => 4,
            'inversa' => 8
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 4,
            'tipus_relacio_id' => 9,
            'ue_desti_id' => 1,
            'inversa' => 7
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 2,
            'tipus_relacio_id' => 10,
            'ue_desti_id' => 3,
            'inversa' => 10
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 3,
            'tipus_relacio_id' => 11,
            'ue_desti_id' => 2,
            'inversa' => 9
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 2,
            'tipus_relacio_id' => 12,
            'ue_desti_id' => 4,
            'inversa' => 12
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 4,
            'tipus_relacio_id' => 12,
            'ue_desti_id' => 2,
            'inversa' => 11
        ]);

        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 5,
            'tipus_relacio_id' => 1,
            'ue_desti_id' => 4,
            'inversa' => 14
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 4,
            'tipus_relacio_id' => 1,
            'ue_desti_id' => 5,
            'inversa' => 13
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 1,
            'tipus_relacio_id' => 2,
            'ue_desti_id' => 5,
            'inversa' => 16
        ]);
        DB::table('relacions')->insert([
            'excavacio_id' => 1,
            'ue_origen_id' => 5,
            'tipus_relacio_id' => 3,
            'ue_desti_id' => 1,
            'inversa' => 15
        ]);
    }

}
