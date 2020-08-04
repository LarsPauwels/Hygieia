<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF;

use App\User;
use App\Client;
use App\Space;
use App\Item;

use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\ClientCollection as ClientCollection;
use App\Http\Resources\Payment as PaymentResource;

use App\Http\Helpers\MailHelper;
use App\Http\Helpers\FileHelper;
use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class ClientController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/client/list",
     *     tags={"Clients"},
     *     summary="Show all clients.",
     *     operationId="client",
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
    public function getClients(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        $clients = Client::where('name', 'LIKE', "%".$search."%")->orderBy('name', $sort)->paginate($size);

        if (count($clients)) {
            return new ClientCollection($clients);
        }

        return ErrorHelper::notFound('clients');
    }

    /**
     * @OA\Get(
     *     path="/v1/client/{id}",
     *     tags={"Clients"},
     *     summary="Get client by id.",
     *     operationId="clientId",
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
     * Get client by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getClientById($id) {
        $client = Client::find($id);

        if ($client == null) {
           return ErrorHelper::notFound('client', $id);
        }

        if (!empty($client)) {
            return new ClientResource($client);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/client/{id}",
     *     tags={"Clients"},
     *     summary="Create new client",
     *     operationId="clientCreate",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="logo", type="file")
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
     * Create client by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createClient(Request $req) {
        $validation = ValidationHelper::client($req->all(), null);

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $client = new Client;

        $client->user_id = Auth()->user()->id;
        $client->name = $req->name;
        $client->address = $req->address;
        $client->email = $req->email;
        $client->created_at = date('Y-m-d H:i:s');
        $client->updated_at = date('Y-m-d H:i:s');

        if ($req->has('logo')) {
            $folder = 'uploads/logos/';
            $file = new FileHelper();
            $filePath = $file->upload($req->file('logo'), $folder, $req->name);
            $client->logo_path = $filePath;
        }

        if ($client->save()) {
            return new ClientResource($client);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/client/{id}",
     *     tags={"Clients"},
     *     summary="Update client by id.",
     *     operationId="clientUpdate",
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
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="logo", type="string")
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
     * Update client by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateClientById(Request $req, $id) {
        $validation = ValidationHelper::client($req->all(), $id);

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        $client->name = $req->name;
        $client->address = $req->address;
        $client->email = $req->email;
        $client->updated_at = date('Y-m-d H:i:s');

        if ($req->has('logo')) {
            if (!is_null($client->logo_path)) {
                $file = new FileHelper();
                $filePath = $file->remove($client->logo_path);
            }

            $folder = 'uploads/logos/';
            $file = new FileHelper();
            $filePath = $file->upload($req->file('logo'), $folder, $req->name);
            $client->logo_path = $filePath;
        }

        if ($client->save()) {
            return new ClientResource($client);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/client/{id}",
     *     tags={"Clients"},
     *     summary="Delete client",
     *     operationId="clientDelete",
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
     * Create client by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteClientById($id) {
        $client = Client::with('spaces')->find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        if (!is_null($client->logo_path)) {
            $file = new FileHelper();
            $filePath = $file->remove($client->logo_path);
        }

        $client->spaces()->each(function($space) {
            $space->items()->each(function($item) {
                $item->products()->detach();
                $item->delete();
            });
            $space->delete();
        });

        if ($client->delete()) {
            return new ClientResource($client);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/client/{id}/payed",
     *     tags={"Clients"},
     *     summary="Update client if he/she payed.",
     *     operationId="userPay",
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
     *             @OA\Property(property="expires", type="datetime")
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
     * Update client if he/she payed api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateClientPay(Request $req, $id) {
        $validation = ValidationHelper::payment($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        $user = User::withTrashed()->updateOrCreate(
            ['email' => $client->email],
            [
                'name' => $client->name, 
                'email' => $client->email,
                'role_id' => 2, 
                'deleted_at' => null
            ]
        );

        if($user->wasRecentlyCreated) {
            $password = Str::random(12);
            $user->password = Hash::make($password);
            $user->save();

            MailHelper::newAccount($client, $password);
        }

        $date = new \DateTime($req->expires);
        $client->expire_payment = $date->format('Y-m-d H:i:s');
        $client->updated_at = date('Y-m-d H:i:s');

        if ($client->save()) {
            $user->setAttribute('client', $client);

            return new PaymentResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/client/{id}/expired",
     *     tags={"Clients"},
     *     summary="Update client when payment is expired.",
     *     operationId="clientExpired",
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
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Update client when payment is expired api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateClientExpire($id) {
        $client = Client::find($id);
        
        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        if ($client->expire_payment == null) {
            $message = 'This client doesn\'t have a payment to expire.';
            return ErrorHelper::exceptions($message, 404);
        }

        $client->expire_payment = NULL;
        $client->updated_at = date('Y-m-d H:i:s');

        $user = User::where('email', $client->email)->first();

        if ($user == null) {
            $message = 'There was no user found with the email \''.$client->email.'\'.';
            return ErrorHelper::exceptions($message, 404);
        }

        if ($client->save() && $user->delete()) {
            $user->setAttribute('client', $client);
            return new PaymentResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Get(
     *     path="/v1/client/{id}/pdf",
     *     tags={"Clients"},
     *     summary="Generate PDF for this client.",
     *     operationId="generatepdf",
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
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Generate PDF api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function generatePDF($id) {
        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        $exists = 0;
        $client->spaces()->each(function($space) use (&$exists) {
            $exists += $space->items()->exists();   
        });

        if ($exists === 0) {
            $message = 'There are no items to generate a PDF.';
            return ErrorHelper::exceptions($message, 404);
        }

        set_time_limit(0);

        $pdf = PDF::loadView('pdf.document', ['data' => $client->spaces, 'client' => $client])->setPaper('a4', 'portrait');
        $pdf->save(storage_path('document.pdf'));
        $clientName = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($client->name));
        return $pdf->download($clientName.'_'.date("d/m/Y").'.pdf');
    }

    private function getTablePdf($client, $month, $year, $path) {
        $pdf = PDF::loadView('pdf.tabel', ['data' => $client->spaces, 'client' => $client, 'month' => $month, 'year' => $year])
            ->setPaper('a4', 'landscape');
        $pdf->save(storage_path($path));
        return $pdf;
    }

    /**
     * @OA\Get(
     *     path="/v1/client/{id}/table/{year}/{month}",
     *     tags={"Clients"},
     *     summary="Generate table for this client.",
     *     operationId="generateTable",
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
     *         name="year",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="month",
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
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Generate table api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function generateTable($id, $year, $month){
        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        set_time_limit(0);
        $pdf = $this->getTablePdf($client, $month, $year, "document.pdf");
        $clientName = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($client->name));
        $dateObj = \DateTime::createFromFormat('!m', $month);
        return $pdf->download($clientName.'_'.$dateObj->format('F').'_'.$year.'.pdf');
    }

    /**
     * @OA\Get(
     *     path="/v1/client/{id}/tables/{year}",
     *     tags={"Clients"},
     *     summary="Generate tables for this client.",
     *     operationId="generateTables",
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
     *         name="year",
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
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Generate tables api  
     * 
     * @return \Illuminate\Http\Response 
     */
    public function generateTables($id, $year) {
        $client = Client::find($id);

        if ($client == null) {
            return ErrorHelper::notFound('client', $id);
        }

        set_time_limit(0);
        $path = storage_path('tables');
        if(!file_exists($path)) {
            mkdir($path);
        }

        $clientName = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($client->name));
        for($i = 1; $i < 13; ++$i) {
            $dateObj = \DateTime::createFromFormat('!m', $i);
            $pathName = $clientName.'_'.$dateObj->format('F');
            $this->getTablePdf($client, $i, $year, "tables/$pathName.pdf");
        }

        $zipName = $clientName.'_'.$year.'.zip';
        $zipFile = storage_path($zipName);
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zipFile);
    }
}