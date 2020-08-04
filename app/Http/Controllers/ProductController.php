<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Product;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection as ProductCollection;

use App\Http\Helpers\FileHelper;
use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class ProductController extends Controller {
	/**
     * @OA\Get(
     *     path="/v1/product/list",
     *     tags={"Products"},
     *     summary="Show all products.",
     *     operationId="product",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page_size",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="asc, desc" 
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Get all clients api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getProducts(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);

        if ($req->page_size === null) {
            $size = 50;
        }

        if ($req->sort === null) {
            $sort = 'asc';
        }

        $products = Product::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($products)) {
            return new ProductCollection($products);
        }

        return ErrorHelper::notFound('products');
    }

    /**
     * @OA\Get(
     *     path="/v1/product/{id}",
     *     tags={"Products"},
     *     summary="Get product by id.",
     *     operationId="productId",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get product by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getProductById($id) {
        $product = Product::find($id);

        if ($product == null) {
           return ErrorHelper::notFound('product', $id);
        }

        if (!empty($product)) {
            return new ProductResource($product);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/product",
     *     tags={"Products"},
     *     summary="Create new product",
     *     operationId="productCreate",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="quantity", type="string"),
     *             @OA\Property(property="information", type="file"),
     *             @OA\Property(property="image_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Create product by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createProduct(Request $req) {
        $validation = ValidationHelper::product($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $product = new Product;

        $product->user_id = Auth()->user()->id;
        $product->name = $req->name;
        $product->quantity = $req->quantity;
        if ($req->has('image_id')) {
            $product->image_id = $req->image_id;
        }
        $product->created_at = date('Y-m-d H:i:s');
        $product->updated_at = date('Y-m-d H:i:s');

        if ($req->has('information')) {
            $folder = 'uploads/info/';
            $file = new FileHelper();
            $filePath = $file->upload($req->file('information'), $folder, $req->name);
            $product->information = $filePath;
        }

        if ($product->save()) {
            return new ProductResource($product);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/product/{id}",
     *     tags={"Products"},
     *     summary="Update product by id.",
     *     operationId="productUpdate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="quantity", type="string"),
     *             @OA\Property(property="information", type="file"),
     *             @OA\Property(property="image_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Update product by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateProductById(Request $req, $id) {
        $validation = ValidationHelper::product($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $product = Product::find($id);

        if ($product == null) {
            return ErrorHelper::notFound('product', $id);
        }

        if (!count($req->all())) {
            $message = 'The fields \'name\' and \'quantity\' are required.';
            return ErrorHelper::exceptions($message, 500);
        }

        $product->name = $req->name;
        $product->quantity = $req->quantity;
        if ($req->has('image_id')) {
            $product->image_id = $req->image_id;
        }
        $product->updated_at = date('Y-m-d H:i:s');

        if ($req->has('information')) {
            if (!is_null($product->information)) {
                $file = new FileHelper();
                $filePath = $file->remove($product->information);
            }

            $folder = 'uploads/info/';
            $file = new FileHelper();
            $filePath = $file->upload($req->file('information'), $folder, $req->name);
            $product->information = $filePath;
        }

        if ($product->save()) {
            return new ProductResource($product);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/product/{id}",
     *     tags={"Products"},
     *     summary="Delete product",
     *     operationId="productDelete",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Create product by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteProductById($id) {
        $product = Product::find($id);

        if ($product == null) {
            return ErrorHelper::notFound('product', $id);
        }

        if (!is_null($product->information)) {
            $file = new FileHelper();
            $filePath = $file->remove($product->information);
        }

        if ($product->delete()) {
            return new ProductResource($product);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}