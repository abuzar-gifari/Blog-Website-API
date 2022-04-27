<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'header_logo'=>'Panteuro',
            'footer_logo'=>'Panteuro',	
            'footer_desc'=>$this->faker->paragraph(),	
            'email'=>$this->faker->email(),
            'phone'=>'01783753653',
            'address'=>'Bangladesh, Mirpur-13',
            'facebook'=>'facebook',
            'instagram'=>'instagram',
            'youtube'=>'youtube',
            'about_title'=>$this->faker->sentence(),
            'about_desc'=>$this->faker->paragraph(3)

        ];
    }
}
