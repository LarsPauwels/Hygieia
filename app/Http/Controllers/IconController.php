<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;

use App\Icon;

use App\Http\Resources\Icon as IconResource;
use App\Http\Resources\IconCollection as IconCollection;

use App\Http\Helpers\FileHelper;
use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class IconController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/icon/list",
     *     tags={"Icons"},
     *     summary="Show all icons.",
     *     operationId="icon",
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
     * Get all icons api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getIcons(Request $req) {
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

        $icons = Icon::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($icons)) {
            return new IconCollection($icons);
        }

        return ErrorHelper::notFound('icons');
    }

    /**
     * @OA\Get(
     *     path="/v1/icon/{id}",
     *     tags={"Icons"},
     *     summary="Get icon by id.",
     *     operationId="iconId",
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
    public function getIconById($id) {
        $icon = Icon::find($id);

        if ($icon == null) {
           return ErrorHelper::notFound('icon', $id);
        }

        if (!empty($icon)) {
            return new IconResource($icon);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/icon",
     *     tags={"Icons"},
     *     summary="Create new icon",
     *     operationId="iconCreate",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="image", type="file"),
     *             @OA\Property(property="type", type="string")
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
     * Create icon by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createIcon(Request $req) {
        $validation = ValidationHelper::icon($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $icon = new Icon;

        $icon->name = $req->name;
        $icon->type = $req->type;
        $icon->created_at = date('Y-m-d H:i:s');
        $icon->updated_at = date('Y-m-d H:i:s');

        $folder = 'uploads/icons/';
        $file = new FileHelper();
        $filePath = $file->upload($req->file('image'), $folder, $req->name);
        $icon->image_url = $filePath;

        if ($icon->save()) {
            return new IconResource($icon);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/icon/{id}",
     *     tags={"Icons"},
     *     summary="Update icon by id.",
     *     operationId="iconUpdate",
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
     *             @OA\Property(property="image", type="file"),
     *             @OA\Property(property="type", type="string")
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
     * Update icon by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateIconById(Request $req, $id) {
        $validation = ValidationHelper::icon($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $icon = Icon::find($id);

        if ($icon == null) {
            return ErrorHelper::notFound('icon', $id);
        }

        $icon->name = $req->name;
        $icon->type = $req->type;
        $icon->updated_at = date('Y-m-d H:i:s');

        if (!is_null($icon->image_url)) {
            $file = new FileHelper();
            $filePath = $file->remove($icon->image_url);
        }

        $folder = 'uploads/icons/';
        $file = new FileHelper();
        $filePath = $file->upload($req->file('image'), $folder, $req->name);
        $icon->image_url = $filePath;

        if ($icon->save()) {
            return new IconResource($icon);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/icon/{id}",
     *     tags={"Icons"},
     *     summary="Delete icon",
     *     operationId="iconDelete",
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
     * Create icon by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteIconById($id) {
        $icon = Icon::find($id);

        if ($icon == null) {
            return ErrorHelper::notFound('icon', $id);
        }

        if (!is_null($icon->image_url)) {
            $file = new FileHelper();
            $filePath = $file->remove($icon->image_url);
        }

        if ($icon->delete()) {
            return new IconResource($icon);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

}