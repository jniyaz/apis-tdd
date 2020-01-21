<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->post('/authors', $this->data());

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1986/06/30', $author->first()->dob->format('Y/m/d'));
    } 

    /** @test */
    public function author_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function author_dob_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));
        $response->assertSessionHasErrors('dob');
    }

    private function data() {
        return [
            'name' => 'Niyaz',
            'email' => 'niyaz.developer@gmail.com',
            'dob' => '30-06-1986',
            'phone' => '0172334226'
        ];        
    }

}
