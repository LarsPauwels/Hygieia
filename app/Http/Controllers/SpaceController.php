<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Client;
use App\Space;

use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\ClientCollection as ClientCollection;
use App\Http\Resources\Space as SpaceResource;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class SpaceController extends Controller {

    /**
     * @OA\Get(
     *     path="/v1/client/{id}/space/list",
     *     tags={"Spaces"},
     *     summary="Get spaces by client.",
     *     operationId="space",
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
     * Get space by client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getSpaces(Request $req, $id) {
        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
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

            $spaces = Client::with(['spaces' => function($q) use ($size, $sort, $search) {
                $q->orderBy('name', $sort);
                $q->paginate($size);
                $q->where('name', 'LIKE', "%".$search."%");
            }])->find($id);
            
            
            if (!empty($spaces)) {
                return new ClientResource($spaces);
            }

            return ErrorHelper::notFound('spaces');
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/space/{id}",
     *     tags={"Spaces"},
     *     summary="Get space by id.",
     *     operationId="spaceId",
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
     * Get space by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSpaceById($id) {
        $space = Space::find($id);

        if ($space == null) {
           return ErrorHelper::notFound('space', $id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
           return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            if (!empty($space)) {
                return new SpaceResource($space);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/client/{id}/space",
     *     tags={"Spaces"},
     *     summary="Create new space",
     *     operationId="spaceCreate",
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
     *             @OA\Property(property="name", type="string")
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
     * Create space by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createSpace(Request $req, $id) {
        $validation = ValidationHelper::space($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $client = Client::find($id);

        if ($client == null) {
           return ErrorHelper::notFound('client', $id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            if (!count($req->all())) {
                $message = 'The field \'name\' is required.';
                return ErrorHelper::exceptions($message, 500);
            }

            $space = new Space;

            $space->client_id = $id;
            $space->name = $req->name;
            $space->created_at = date('Y-m-d H:i:s');
            $space->updated_at = date('Y-m-d H:i:s');

            if ($space->save()) {
                return new SpaceResource($space);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/v1/space/{id}",
     *     tags={"Spaces"},
     *     summary="Update space by id.",
     *     operationId="spaceUpdate",
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
     *             @OA\Property(property="name", type="string")
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
     * Update space by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateSpaceById(Request $req, $id) {
        $validation = ValidationHelper::space($req->all());

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

            if (!count($req->all())) {
                $message = 'The field \'name\' is required.';
                return ErrorHelper::exceptions($message, 500);
            }

            $space->name = $req->name;
            $space->updated_at = date('Y-m-d H:i:s');

            if ($space->save()) {
                return new SpaceResource($space);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/space/{id}",
     *     tags={"Spaces"},
     *     summary="Delete space",
     *     operationId="spaceDelete",
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
     * Create space by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteSpaceById($id) {
        $space = Space::find($id);

        if ($space == null) {
            return ErrorHelper::notFound('space', $id);
        }

        $client = Client::find($space->client_id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $space->client_id);
        }

        if (Gate::authorize('correctUser', $client->email)) {
            if ($space->delete() && $space->items()->delete()) {
                return new SpaceResource($space);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }
}