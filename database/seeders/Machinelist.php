<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class Machinelist extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();
         DB::statement('ALTER TABLE machine_lists AUTO_INCREMENT = 1');
         DB::table('machine_lists')->truncate();

         for( $i=1; $i<=150; $i++ )
            {
                DB::table('machine_lists')->insert([
                    ['name' => $i,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                ]);
            }
    }
}
