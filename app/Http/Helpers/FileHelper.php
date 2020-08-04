<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileHelper {

    public function upload($image, $folder, $clientName) {
        $fileName = Str::slug($clientName).'_'.time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path($folder), $fileName);
        return $folder.$fileName;
    }

    public function remove($filePath) {
        File::delete($filePath);
    }
}