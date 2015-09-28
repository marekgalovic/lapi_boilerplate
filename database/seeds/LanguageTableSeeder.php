<?php

use Illuminate\Database\Seeder;

use App\Models\Language\Language;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Language::create([
        	'name' => 'English',
        	'shortcut' => 'en',
        	'is_default' => true
        	]);

        Language::create([
            'name' => 'Slovenský',
            'shortcut' => 'sk',
            'is_default' => true
            ]);
    }
}
