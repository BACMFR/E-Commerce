<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $response = $this->productService->getAllProducts();
        return response()->json($response, $response['status']);
    }

    public function store(Request $request)
    {
        $response = $this->productService->createProduct($request->all());
        return response()->json($response, $response['status']);
    }

    public function show($id)
    {
        $response = $this->productService->getProductById($id);
        return response()->json($response, $response['status']);
    }

    public function update(Request $request, $id)
    {
        $response = $this->productService->updateProduct($id, $request->all());
        return response()->json($response, $response['status']);
    }

    public function destroy($id)
    {
        $response = $this->productService->deleteProduct($id);
        return response()->json($response, $response['status']);
    }
}
