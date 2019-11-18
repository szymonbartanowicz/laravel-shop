<?php


namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Product;


class ProductControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testProductControllerIndex()
    {
        $response = $this->get('/api/products');
        $products = Product::all();
        $response->assertStatus(200)
            ->assertJson($products->toArray());
    }

    public function testProductControllerShow()
    {
        $product = Product::orderBy('id', 'desc')->first();
        $response = $this->get('api/products/' . $product->id);
        $response->assertStatus(200)
            ->assertJson($product->toArray());
    }

    public function testProductControllerStore()
    {
        $data = factory(\App\Models\Product::class)->make()->toArray();
        $response = $this->post('api/products', $data);
        $response->assertStatus(200)
            ->assertJson([
                    'created' => true
                ]
            );
    }

    public function testProductControllerUpdate()
    {
        $data = factory(\App\Models\Product::class)->make()->toArray();
        $productId = Product::orderBy('id', 'desc')->first()->id;
        $response = $this->put('api/products/' . $productId, $data);
        $response->assertStatus(200)
            ->assertJson([
                'edited' => true
            ]);
    }

    public function testProductControllerDestroy()
    {
        $productId = Product::orderBy('id', 'desc')->first()->id;
        $response = $this->delete('api/products/' . $productId);
        $response->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }
}
