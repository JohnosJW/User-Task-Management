<?php

declare(strict_types = 1);

namespace Tests\Controller\Api\V1;


use App\Models\Task;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class TaskControllerTest
 * @package Tests\Controller\Api\V1
 */
class TaskControllerTest extends TestCase
{
    /** @test */
    public function testIndex(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        Passport::actingAs(
            $user,
            ['create-servers']
        );

        $response = $this->get('/api/v1/tasks');
        $response->assertStatus(200);
        $response->assertJson(['data' => [
            0 => [
                "id" => $task->id,
                "user_id"=> $task->user_id,
                "title" => $task->title,
                "description" => $task->description,
                "status" => Task::STATUS_ACTIVE,
            ]
        ]]);
    }

    /** @test */
    public function testCreate(): void
    {
        $title = "Apple";
        $description = "Apple apple ...";

        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $response = $this->postJson('/api/v1/tasks', [
            "title" => $title,
            "description" => $description
        ]);
        $response->assertStatus(200);
        $response->assertJson(['data' => [
            "title" => $title,
            "description" => $description,
            "status" => Task::STATUS_ACTIVE
        ]]);
    }

    /** @test */
    public function testSetStatus()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        Passport::actingAs(
            $user,
            ['create-servers']
        );

        $response = $this->post('/api/v1/tasks/' . $task->id . '/set-status/' . Task::STATUS_REJECTED);
        $response->assertStatus(200);
        $response->assertJson(['data' => [
            "status" => Task::STATUS_REJECTED
        ]]);

        $response = $this->post('/api/v1/tasks/' . $task->id . '/set-status/' . Task::STATUS_DONE);
        $response->assertStatus(200);
        $response->assertJson(['data' => [
            "status" => Task::STATUS_DONE
        ]]);
    }
}
