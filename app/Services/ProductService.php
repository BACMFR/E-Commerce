<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        $products = Product::all();
        return ['status' => 200, 'products' => $products];
    }

    public function createProduct($data)
    {
        $product = Product::create($data);

        if ($product) {
            return ['status' => 201, 'product' => $product];
        }

        return ['status' => 400, 'error' => 'Product not created'];
    }

    public function getProductById($id)
    {
        $product = Product::find($id);

        if ($product) {
            return ['status' => 200, 'product' => $product];
        }

        return ['status' => 404, 'error' => 'Product not found'];
    }

    public function updateProduct($id, $data)
    {
        $product = Product::find($id);

        if ($product && $product->update($data)) {
            return ['status' => 200, 'product' => $product];
        }

        return ['status' => 400, 'error' => 'Product not updated'];
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product && $product->delete()) {
            return ['status' => 200, 'message' => 'Product deleted successfully'];
        }

        return ['status' => 400, 'error' => 'Product not deleted'];
    }
}
