<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $userId = rand(1, 10);
            $to = rand(1, 10);
        } while($userId === $to);
    
        return [
            'user_id' => $userId,
            'from' => $userId,
            'to' => $to,
            'subject' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'read_at' => $this->faker->dateTimeBetween('-15 days', 'this week'),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'this week')
        ];
    }
}
