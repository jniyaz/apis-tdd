<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'niyaz'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }
    
    /**
     * @test  
    */
    public function a_title_is_required(){
        
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'niyaz'
        ]);

        $response->assertSessionHasErrors('title');

    }
    
    /** @test  */
    public function a_author_is_required(){
        
        $response = $this->post('/books', [
            'title' => 'cool book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }
    
    /** @test  */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'niyaz'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}