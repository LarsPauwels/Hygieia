<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserCollection;
use App\Http\Resources\ClientCollection as ClientCollection;
use App\Http\Resources\ProductCollection as ProductCollection;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class UserController extends Controller {
	/**
     * @OA\Get(
     *     path="/v1/user/list",
     *     tags={"Users"},
     *     summary="Show all users.",
     *     operationId="user",
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
    public function getUsers(Request $req) {
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

        $users = User::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($users)) {
            return new UserCollection($users);
        }

        return ErrorHelper::notFound('users');
    }

    /**
     * @OA\Get(
     *     path="/v1/user/clients",
     *     tags={"Users"},
     *     summary="Show all clients from user.",
     *     operationId="userClients",
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
    public function getUserClients(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $id = Auth()->user()->id;

        if ($req->page_size === null) {
            $size = 50;
        }

        if ($req->sort === null) {
            $sort = 'asc';
        }

        $clients = User::find($id)->clients()->where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($clients)) {
            return new ClientCollection($clients);
        }

        return ErrorHelper::notFound('clients');
    }

    /**
     * @OA\Get(
     *     path="/v1/user/products",
     *     tags={"Users"},
     *     summary="Show all products from user.",
     *     operationId="userProducts",
     *     security={{"bearerAuth":{}}},
     *
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
    public function getUserProducts(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $id = Auth()->user()->id;

        if ($req->page_size === null) {
            $size = 50;
        }

        if ($req->sort === null) {
            $sort = 'asc';
        }

        $products = User::find($id)->products()->where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($products)) {
            return new ProductCollection($products);
        }

        return ErrorHelper::notFound('products');
    }
}