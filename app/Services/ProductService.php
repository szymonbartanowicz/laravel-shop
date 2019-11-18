<?php


namespace App\Services;


use App\Models\Product;


class ProductService
{

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function index()
    {
        return $products = Product::all()->toArray();
    }

    public function store($data)
    {
        try {
            $product = Product::create($data);
            return $product->toArray();
        } catch (\Exception $e) {
            throw new $e;
        }
    }

    public function show($id)
    {
        $product = $this->findById($id);
        return $product->toArray();
    }

    public function destroy($id)
    {
        try {
            $product = $this->findById($id);
            return $deleted = $product->delete();
        } catch (\Exception $e) {
            throw new $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $product = $this->findById($id);
            $updated = $product->update($data);
            return $updated;
        } catch (\Exception $e) {
            throw new $e;
        }
    }
}
