<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    do {
        $userId = rand(1, 10);
        $to = rand(1, 10);
    } while($userId === $to);

    $createdAt = $faker->dateTimeBetween('-30 days', 'this week');
    $readAt = $faker->dateTimeBetween('-15 days', 'this week');

    return [
        'user_id' => $userId,
        'from' => $userId,
        'to' => $to,
        'subject' => $faker->sentence,
        'content' => $faker->paragraph,
        'read_at' => $readAt,
        'created_at' => $createdAt
    ];
});