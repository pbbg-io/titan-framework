<?php

namespace PbbgIo\Titan\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PbbgIo\Titan\Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginLoads()
    {
        $req = $this->get('/login')
        ->assertOk();

//        dd($req);
    }
}