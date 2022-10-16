<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcceptCommercialMessageTest extends TestCase
{
    /**
     * @test
     * //TESTS ne fonctionnent pas
     */
    public function commercialMessageSuccess()
    {
        // $response = $this->patch('api/customers/message/3', ['message'=>0]);
        $response = $this->patch('api/customers/message/3', ['message'=>0]);
        $response->assertStatus(200);
    }

    public function commercialMessageFail()
    {
        $response = $this->patch('api/customers/message/3');
        $response->assertStatus(422);
    }
}
