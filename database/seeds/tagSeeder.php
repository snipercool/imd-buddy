<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'name'       => 'designer',
            ],
            [
                'name'       => 'star wars',
            ],
            [
                'name'       => 'developer',
            ],
            [
                'name'       => 'honden',
            ],
            [
                'name'       => 'drawing',
            ],
            [
                'name'       => 'marvel',
            ],
            [
                'name'       => 'DC',
            ],
            [
                'name'       => 'php',
            ],
            [
                'name'       => 'javascript',
            ],
            [
                'name'       => 'photography',
            ],
            [
                'name'       => 'gaming',
            ],
            [
                'name'       => 'sports',
            ],
            [
                'name'       => 'fitness',
            ],
            [
                'name'       => 'memelord',
            ],
            [
                'name'       => 'vlogger',
            ],
            [
                'name'       => 'youtuber',
            ],
            [
                'name'       => 'blogger',
            ],
            [
                'name'       => 'animal lover',
            ],
            [
                'name'       => 'wizard',
            ],
            [
                'name'       => 'reading',
            ],
            [
                'name'       => 'Comic sans',
            ],

        ]);
    }
}
