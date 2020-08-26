<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Message;

class FeatureMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test case
     *
     * @return void
     */   
    public function setUp():void
    {
        parent::setUp();
        $this->seed();
    }    


    public function testGetMessages()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');
        $this->json('GET', 'api/messages', ['Accept' => 'application/json'])->assertStatus(200)->assertJsonCount(10);
    }

    public function testGetSentMessages()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');
        $this->json('GET', 'api/messages?mailbox=sent', ['Accept' => 'application/json'])->assertStatus(200)->assertJsonCount(10);
    }

    public function testGetRemovedMessages()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');
        $this->json('GET', 'api/messages?mailbox=archived', ['Accept' => 'application/json'])->assertStatus(200)->assertJsonCount(6);
    }

    public function testPostMessage()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');

        $msgArr = [
            'user_id' => 1,
            'from' => 1,
            'to' => 2,
            'subject' => 'Test',
            'content' => 'TestContent'
        ];

        $response = $this->json('POST', 'api/messages', $msgArr)->assertStatus(201);
    }

    public function testPatchMessage()
    {
        $user = User::find(1);
        $this->actingAs($user, 'api');

        $msg = Message::where(['user_id' => $user->id, 'to' => $user->id])->first();

        $msgArr = [
            'archive' => true,
            'read' => true
        ];

        $response = $this->json('PATCH', 'api/messages/' . $msg->id, $msgArr);

        $this->assertNotEquals($response['archived_at'], 'NULL');
        $this->assertNotEquals($response['read_at'], 'NULL');
    }
}