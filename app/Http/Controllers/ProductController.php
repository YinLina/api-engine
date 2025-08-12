<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric'
        ]);

        $product = Product::create($validated);
        if ($product) {
            return new JsonResponse([
                'status' => true,
                'data' => new ProductResource($product),
                'message' => 'Product has been created successfully!'
            ]);
        } else {
            return new JsonResponse([
                'status' => false,
                'message' => 'Failed to create product!'
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function getProduct()
    {
        $product = Product::get();
        if ($product) {

            return new JsonResponse([
                'status' => true,
                // 'data' => $product,
                'data' => ProductResource::collection($product),
                'message' => 'Products fetched successfully!',
            ], 200);
        } else {
            return new JsonResponse([
                'status' => false,
                'message' => 'No products found.'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function searchProduct(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $keyword = $request->query('name');
        $product = Product::where('name', 'like', "%$keyword%")->get();

        // $product = Product::where("name","%{$keyword}%")
        //     // ->where("description", "%{$keyword}%")
        //     ->get();

        if($product){
            return new JsonResponse([
                "status"=> true,
                "data"=> ProductResource::collection($product),
                "message"=> "Search results successfully!",
            ]);
        } else{
            return new JsonResponse([
                "status" => false,
                "message"=> "No matching products found."
            ]);
        }
    }
    // public function show(Product $product)
    // {
    //     // return response()->json($product);
    //     return new JsonResponse(['status'=>true,'data'=>$product]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id) {
        $product = Product::find($id);
        if(!$product){
            return new JsonResponse([
                "status"=> false,
                "message"=> "Product not found.",
            ]);
        }else{
            return new JsonResponse([
            "status"=> true,
            "data"=> new ProductResource($product),
            "message"=> "Product loaded for editing.",
        ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($request->all());

            return new JsonResponse([
                'status' => true,
                'data' => $product,
                'message' => 'Product has been updated!'
            ]);
        } else {
            return new JsonResponse([
                'status' => false,
                'message' => 'Failed to update!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return new JsonResponse([
                'status' => true,
                'message' => 'Product has been deleted'
            ]);
        } else {
            return new JsonResponse([
                'status' => false,
                'message' => 'Failed to delete data'
            ]);
        }
    }
}
