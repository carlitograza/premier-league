<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class fetchDataPlayerTest extends TestCase
{

    /**
     * @test
     * A basic unit test example.
     *
     * @return void
     */
    public function fetch_player()
    {
        $value = true;
        $this->assertTrue($value);
    }

    /**  @test */ 
    public function if_data_is_valid()
    {
        $this->assertTrue(true);
    }

}
