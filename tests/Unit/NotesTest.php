<?php

namespace Tests\Unit;

use App\Note;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function it_can_be_created()
    {
        $note = factory('App\Note')->create();
        $this->assertTrue(true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function it_can_fetch_all_notes()
    {
        $note = factory('App\Note')->create();
        $this->json('GET', 'api/notes')
            ->assertStatus(200)
            ->assertNotEmpty();
    }
}
