<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeopleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/api/people');

        $response->assertStatus(200);
    }
    
    public function test_show()
    {
        $id = rand(1,10);
        $response = $this->get('/api/people/'.$id);

        $response->assertStatus(200);
    }
}
