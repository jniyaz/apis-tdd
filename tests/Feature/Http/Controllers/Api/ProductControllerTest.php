<?php

namespace Tests\Feature\Http\Controllers\Api;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

    // public function non_autheticated_user_cannot_access_product_endpoints()
    // {
    //     $index = $this->json('GET', '/api/products');
    //     $index->assertStatus(401);

    //     $store = $this->json('POST', '/api/products');
    //     $store->assertStatus(401);

    //     $show = $this->json('GET', '/api/products/-1');
    //     $show->assertStatus(401);

    //     $update = $this->json('PUT', '/api/products/-1');
    //     $update->assertStatus(401);

    //     $destroy = $this->json('DELETE', '/api/products/-1');
    //     $destroy->assertStatus(401);
    // }


    /**
     * @test
     */
    public function can_create_a_collection_of_paginated_products()
    {
        $product1 = $this->create('Product');
        $product2 = $this->create('Product');
        $product3 = $this->create('Product');

        $response = $this->actingAs($this->create('User', [], false), 'api')->json('GET', 'api/products');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'price', 'created_at'],
                ],

                'links' => ['first', 'last', 'prev', 'next'],

                'meta'  => [
                    'current_page', 'last_page', 'from', 'to', 'total', 'per_page', 'path'
                ]
            ]);

        \Log::info($response->getContent());
    }


    /**
     * @test
     */
    public function can_create_a_product() {
        $faker = Factory::create();

        // Given
            // user is authenticated (..will come back to this test)

        // When
            // POST request to create a product
            $response = $this->actingAs($this->create('User', [], false), 'api')->json('POST', 'api/products', [
                'name' => $name = $faker->company,
                'slug' => str_slug($name),
                'price' => $price = random_int(10, 100)
            ]);

        // Then
            // product exists
            $response
                    // exactly it shoud return like this otherwise fails
                    ->assertJsonStructure(['id', 'name', 'slug', 'price', 'created_at'])

                    // exactly requested data to be return otherwise fails
                    ->assertJson([
                        'name' => $name,
                        'slug' => str_slug($name),
                        'price' => $price
                    ])

                    // status code
                    ->assertStatus(201);

            \Log::info(1, [$response->getContent()]);

            $this
                ->assertDatabaseHas('products', [
                    'name' => $name,
                    'slug' => str_slug($name),
                    'price' => $price
                ]);
    }

    /**
     * @test
     */
    public function will_it_fail_with_404_if_product_not_found() {
        $response = $this->actingAs($this->create('User', [], false), 'api')->json('GET', "api/product/-1");
        return $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_return_a_product() {

        // Given
        $product = $this->create('Product');

        // When
        $response = $this->actingAs($this->create('User', [], false), 'api')->json('GET', "api/products/$product->id");

        // Then
        $response
                ->assertStatus(200)
                ->assertExactJson([
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'created_at' => $product->created_at
                ]);
    }

    /**
     * @test
     */

    public function will_it_fail_with_404_if_product_needed_to_update_not_found()
    {
        // when
        $response = $this->actingAs($this->create('User', [], false), 'api')->json('PUT', "api/products/-1");
        // then
        return $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_update_a_product()
    {
        $product = $this->create('Product');

        $response = $this->actingAs($this->create('User', [], false), 'api')->json('PUT', "api/products/$product->id", [
            'name' => $product->name.' updated',
            'slug' => str_slug($product->name.' updated'),
            'price' => $product->price + 10
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id' => $product->id,
                'name' => $product->name.' updated',
                'slug' => str_slug($product->name.' updated'),
                'price' => $product->price + 10,
                'created_at' => $product->created_at
            ]);
    }

    /**
     * @test
     */

    public function will_it_fail_with_404_if_product_needed_to_delete_not_found()
    {
        // when
        $response = $this->actingAs($this->create('User', [], false), 'api')->json('DELETE', "api/products/-1");
        // then
        return $response->assertStatus(404);
    }

    /**
     * @test
     */

    public function can_delete_a_product()
    {
        $product = $this->create('Product');
        // when
        $response = $this->actingAs($this->create('User', [], false), 'api')->json('DELETE', "api/products/$product->id");
        // then
        $response
            ->assertStatus(204)
            ->assertSee(null);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);

    }

}
