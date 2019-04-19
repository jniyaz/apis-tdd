<?php

namespace Tests\Feature\Http\Controllers\Api;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_a_product()
    {
        $faker = Factory::create();
        
        // Given
            // user is authenticated (..will come back to this test)
        
        // When
            // POST request to create a product
            $response = $this->json('POST', 'api/products', [
                'name' => $name = $faker->company,
                'slug' => str_slug($name),
                'price' => $price = random_int(10, 100)
            ]);
        
        // Then 
            // product exists
            $response
                    ->assertJsonStructure(['id', 'name', 'price', 'created_at']) // exactly it shoud return like this otherwise fails
                    ->assertJson([
                        'name' => $name,
                        'slug' => str_slug($name),
                        'price' => $price
                    ])  // exactly requested data to be return otherwise fails
                    ->assertStatus(201);
            
            $this
                ->assertDatabaseHas('products', [
                    'name' => $name,
                    'slug' => str_slug($name),
                    'price' => $price
                ]);
    }
}
