<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Product;
use App\Services\ProductService;



class ProductServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testProductServiceFindById()
    {
        $product = Product::orderBy('id', 'desc')->first();
        $product = $product->toArray();
        $service = new ProductService();
        $productId = $product['id'];
        $result = $service->findById($productId)->toArray();
        foreach ($product as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertSame($value, $result[$key]);
        }
    }

    public function testProductServiceIndex()
    {

        $service = new ProductService();

        $result = $service->index();

        $this->assertIsArray($result);

        $count = Product::all()->count();
        $this->assertCount($count, $result);

        if ($count > 0) {
            $this->assertArrayHasKey('id', $result[0]);
        }
    }

    public function testProductServiceShow()
    {
        $product = Product::orderBy('id', 'desc')->first();

        $product = $product->toArray();

        $productId = $product['id'];

        $this->assertGreaterThan(0, $productId);

        $service = new ProductService();

        $result = $service->show($productId);

        $this->assertIsArray($result);

        foreach ($product as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertSame($value, $result[$key]);
        }
    }

    public function testProductServiceStore()
    {
        $data = make('App\Models\Product');

        $service = new ProductService();

        $result = $service->store($data);

        $this->assertIsArray($result);

        $product = $service->show($result['id']);

        foreach ($product as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }

//    public function test_product_length_can_not_exceed_255()
//    {
//        $name = 'A fixed-length string that is always right-padded with spaces to the specified length when stored The range of Length is 1 to 255 characters. Trailing spaces are removed when the value is retrieved. CHAR values are sorted and compared in case-insensitive fashion according to the default character set unless the BINARY keyword is given.';
//        $data = factory(\App\Models\Product::class)->create(['name' => $name])->toArray();
//        dd($data);
//        $service = new ProductService();
//        if($service->store($data)) {
//            return true;
//        }
//        $product = Product::where('name', $data['name'])->get();
//        dd($product);
//    }

    public function testProductServiceUpdate()
    {
        $productId = Product::orderBy('id', 'desc')->first()->id;

        $this->assertGreaterThan(0, $productId);

        $service = new ProductService();

        $result = $service->show($productId);
        $this->assertIsArray($result);

        $this->assertEquals($productId, $result['id']);

        $data = make('App\Models\Product');

        $updated = $service->update($productId, $data);
        $this->assertTrue($updated);
    }

    public function testProductServiceDestroy()
    {
        $productId = Product::orderBy('id', 'desc')->first()->id;

        $this->assertGreaterThan(0, $productId);

        $service = new ProductService();

        $deleted = $service->destroy($productId);

        $this->assertTrue($deleted);
    }
}
