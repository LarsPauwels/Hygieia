<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Frequency;

use App\Http\Resources\Frequency as FrequencyResource;
use App\Http\Resources\FrequencyCollection as FrequencyCollection;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class FrequencyController extends Controller {
	/**
     * @OA\Get(
     *     path="/v1/frequency/list",
     *     tags={"Frequencies"},
     *     summary="Show all frequencies.",
     *     operationId="frequency",
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
     * Get all frequencies api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getFrequencies(Request $req) {
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

        $frequencies = Frequency::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($frequencies)) {
            return new FrequencyCollection($frequencies);
        }

        return ErrorHelper::notFound('frequencies');
    }

    /**
     * @OA\Get(
     *     path="/v1/frequency/{id}",
     *     tags={"Frequencies"},
     *     summary="Get frequency by id.",
     *     operationId="frequencyId",
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
     * Get frequency by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getFrequencyById($id) {
        $frequency = Frequency::find($id);

        if ($frequency == null) {
           return ErrorHelper::notFound('frequency', $id);
        }

        if (!empty($frequency)) {
            return new FrequencyResource($frequency);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/frequency",
     *     tags={"Frequencies"},
     *     summary="Create new frequency",
     *     operationId="frequencyCreate",
     *     security={{"bearerAuth":{}}},
     *     
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
     * Create frequency by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createFrequency(Request $req) {
        $validation = ValidationHelper::frequency($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $frequency = new Frequency;

        $frequency->name = $req->name;
        $frequency->created_at = date('Y-m-d H:i:s');
        $frequency->updated_at = date('Y-m-d H:i:s');

        if ($frequency->save()) {
            return new FrequencyResource($frequency);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/frequency/{id}",
     *     tags={"Frequencies"},
     *     summary="Update frequency by id.",
     *     operationId="frequencyUpdate",
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
     * Update frequency by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateFrequencyById(Request $req, $id) {
        $validation = ValidationHelper::frequency($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $frequency = Frequency::find($id);

        if ($frequency == null) {
            return ErrorHelper::notFound('frequency', $id);
        }

        $frequency->name = $req->name;
        $frequency->updated_at = date('Y-m-d H:i:s');

        if ($frequency->save()) {
            return new FrequencyResource($frequency);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/frequency/{id}",
     *     tags={"Frequencies"},
     *     summary="Delete frequency",
     *     operationId="frequencyDelete",
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
     * Create frequency by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteFrequencyById($id) {
        $frequency = Frequency::find($id);

        if ($frequency == null) {
            return ErrorHelper::notFound('frequency', $id);
        }

        if ($frequency->delete()) {
            return new FrequencyResource($frequency);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}