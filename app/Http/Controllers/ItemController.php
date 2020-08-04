<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\Space;
use App\Item;

use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemCollection as ItemCollection;
use App\Http\Resources\ItemProduct as ItemProductResource;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class ItemController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/space/{id}/item/list",
     *     tags={"Items"},
     *     summary="Get items by client.",
     *     operationId="item",
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get item by client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getItems(Request $req, $id) {
        $space = Space::with('client')->find($id);

        if ($space == null) {
            return ErrorHelper::notFound('space', $id);
        }

        if (Gate::authorize('correctUser', $space->client->email)) {

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

            $items = Item::select('items.*')
                ->join('spaces', 'spaces.id', '=', 'items.space_id')
                ->where('spaces.id', $id)
                ->orderBy('items.name', $sort)
                ->where('items.name', 'LIKE', "%".$search."%")
                ->paginate($size);

            if (!empty($items)) {
                return new ItemCollection($items);
            }

            return ErrorHelper::notFound('items');
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/item/{id}",
     *     tags={"Items"},
     *     summary="Get item by id.",
     *     operationId="itemId",
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
     * Get item by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getItemById($id) {
        $item = Item::find($id);

        if ($item == null) {
           return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
           return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            if (!empty($item)) {
                return new ItemResource($item);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/space/{id}/item",
     *     tags={"Items"},
     *     summary="Create new item",
     *     operationId="itemCreate",
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
     *             @OA\Property(property="frequency_id", type="integer"),
     *             @OA\Property(property="procedure_id", type="integer"),
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
     * Create item by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createItem(Request $req, $id) {
        $validation = ValidationHelper::item($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $space = Space::find($id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
           return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            $item = new Item;

            $item->name = $req->name;
            $item->space_id = $id;
            $item->frequency_id = $req->frequency_id;
            $item->procedure_id = $req->procedure_id;
            if ($req->has('image_id')) {
                $item->image_id = $req->image_id;
            }
            $item->created_at = date('Y-m-d H:i:s');
            $item->updated_at = date('Y-m-d H:i:s');

            if ($item->save()) {
                return new ItemResource($item);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/v1/item/{id}",
     *     tags={"Items"},
     *     summary="Update item by id.",
     *     operationId="itemUpdate",
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
     *             @OA\Property(property="frequency_id", type="integer"),
     *             @OA\Property(property="procedure_id", type="integer"),
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
     * Update item by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateItemById(Request $req, $id) {
        $validation = ValidationHelper::item($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $item = Item::find($id);

        if ($item == null) {
            return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            $item->name = $req->name;
            $item->frequency_id = $req->frequency_id;
            $item->procedure_id = $req->procedure_id;
            if ($req->has('image_id')) {
                $item->image_id = $req->image_id;
            }
            $item->updated_at = date('Y-m-d H:i:s');

            if ($item->save()) {
                return new ItemResource($item);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/item/{id}",
     *     tags={"Items"},
     *     summary="Delete item",
     *     operationId="itemDelete",
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
     * Create item by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteItemById($id) {
        $item = Item::find($id);

        if ($item == null) {
            return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            if ($item->delete()) {
                return new ItemResource($item);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/item/{id}/product",
     *     tags={"Items"},
     *     summary="Get all products that the item contains.",
     *     operationId="itemProduct",
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
     * Get all products that the item contains api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getItemProduct($id) {
        $item = Item::with('products')->find($id);

        if ($item == null) {
            return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            return new ItemProductResource($item);

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/item/{id}/product",
     *     tags={"Items"},
     *     summary="Create new product for this item.",
     *     operationId="itemProductCreate",
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
     *             @OA\Property(property="product_id", type="string")
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
     * Create new product for this item api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createItemProduct(Request $req, $id) {
        $validation = ValidationHelper::itemProduct($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $item = Item::with('products')->find($id);

        if ($item == null) {
            return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            $item->products()->syncWithoutDetaching([$req->product_id]);
            $item = Item::with('products')->find($id);
            return new ItemProductResource($item);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/item/{id}/product",
     *     tags={"Items"},
     *     summary="Delete product from this item.",
     *     operationId="itemProductDelete",
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
     *             @OA\Property(property="product_id", type="string")
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
     * Delete product from this item api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteItemProduct(Request $req, $id) {
        $validation = ValidationHelper::itemProduct($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $item = Item::with('products')->find($id);

        if ($item == null) {
            return ErrorHelper::notFound('item', $id);
        }

        $space = Space::find($item->space_id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $item->space_id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            $item = $item->products()->detach($req->product_id);
            $item = Item::with('products')->find($id);
            return new ItemProductResource($item);
        }
    }
}