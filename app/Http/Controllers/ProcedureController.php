<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Procedure;

use App\Http\Resources\Procedure as ProcedureResource;
use App\Http\Resources\ProcedureCollection as ProcedureCollection;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class ProcedureController extends Controller {
	/**
     * @OA\Get(
     *     path="/v1/procedure/list",
     *     tags={"Procedures"},
     *     summary="Show all procedures.",
     *     operationId="procedure",
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
     * Get all procedures api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getProcedures(Request $req) {
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

        $procedures = Procedure::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($procedures)) {
            return new ProcedureCollection($procedures);
        }

        return ErrorHelper::notFound('procedures');
    }

    /**
     * @OA\Get(
     *     path="/v1/procedure/{id}",
     *     tags={"Procedurs"},
     *     summary="Get procedure by id.",
     *     operationId="procedureId",
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
     * Get procedure by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getProcedureById($id) {
        $procedure = Procedure::find($id);

        if ($procedure == null) {
           return ErrorHelper::notFound('procedure', $id);
        }

        if (!empty($procedure)) {
            return new ProcedureResource($procedure);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/procedure",
     *     tags={"Procedures"},
     *     summary="Create new procedure",
     *     operationId="procedureCreate",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string")
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
     * Create procedure by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createProcedure(Request $req) {
        $validation = ValidationHelper::procedure($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $procedure = new Procedure;

        $procedure->name = $req->name;
        $procedure->description = $req->description;
        $procedure->created_at = date('Y-m-d H:i:s');
        $procedure->updated_at = date('Y-m-d H:i:s');

        if ($procedure->save()) {
            return new ProcedureResource($procedure);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/procedure/{id}",
     *     tags={"Procedures"},
     *     summary="Update procedure by id.",
     *     operationId="procedureUpdate",
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
     *             @OA\Property(property="description", type="string")
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
     * Update procedure by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateProcedureById(Request $req, $id) {
        $validation = ValidationHelper::procedure($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $procedure = Procedure::find($id);

        if ($procedure == null) {
            return ErrorHelper::notFound('procedure', $id);
        }

        if (!count($req->all())) {
            $message = 'The fields \'name\' and \'description\' are required.';
            return ErrorHelper::exceptions($message, 500);
        }

        $procedure->name = $req->name;
        $procedure->description = $req->description;
        $procedure->updated_at = date('Y-m-d H:i:s');

        if ($procedure->save()) {
            return new ProcedureResource($procedure);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/procedure/{id}",
     *     tags={"Procedures"},
     *     summary="Delete procedure",
     *     operationId="procedureDelete",
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
     * Create procedure by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteProcedureById($id) {
        $procedure = Procedure::find($id);

        if ($procedure == null) {
            return ErrorHelper::notFound('procedure', $id);
        }

        if ($procedure->delete()) {
            return new ProcedureResource($procedure);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}