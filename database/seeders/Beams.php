<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class Beams extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();
         DB::statement('ALTER TABLE beam_lists AUTO_INCREMENT = 1');
         DB::table('beam_lists')->truncate();

         for( $i=1; $i<=150; $i++ )
            {
                DB::table('beam_lists')->insert([
                    ['name' => $i.'U','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                    ['name' => $i.'N','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                ]);
            }
    }
}
