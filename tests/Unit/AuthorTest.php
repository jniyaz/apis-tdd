<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function except_author_name_other_fields_can_be_nullable()
    {
        Author::firstOrCreate([
            'name' => 'test',
            'email' => 'test@test.com'
        ]);

        $this->assertCount(1, Author::all());
    }
}
