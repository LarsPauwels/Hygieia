<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidationHelper {

    /** 
     * checks if validation is valid for the attributes
     * 
     * @return boolean
     */ 
    public static function attributes(array $data) {
        if (array_key_exists('sort', $data)) {
            $data['sort'] = strtolower($data['sort']);
        }

        $validation = Validator::make($data, [
            'page' => ['integer'],
            'page_size' => ['integer', 'min:1', 'max:200'],
            'sort' => ['string', 'regex:(asc|desc)'],
            'search' => ['string', 'max:80']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }
	
	/** 
     * checks if validation is valid for the Auth functions
     * 
     * @return boolean
     */ 
	public static function auth(array $data) {
		$validation = Validator::make($data, [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
	}

    /** 
     * checks if validation is valid for the Auth forgotPassword function
     * 
     * @return boolean
     */ 
    public static function authForgot(array $data) {
        $validation = Validator::make($data, [
            'email' => ['required', 'email', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the client functions
     * 
     * @return boolean
     */ 
    public static function client(array $data, $id) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('clients')->ignore($id)],
            'logo' => ['image', 'max:10240']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the client payment functions
     * 
     * @return boolean
     */ 
    public static function payment(array $data) {
        $validation = Validator::make($data, [
            'expires' => ['required', 'date']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the frequency functions
     * 
     * @return boolean
     */ 
    public static function frequency(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the icon functions
     * 
     * @return boolean
     */ 
    public static function icon(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['image', 'max:10240'],
            'type' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the item functions
     * 
     * @return boolean
     */ 
    public static function item(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'frequency_id' => ['required', 'integer'],
            'procedure_id' => ['required', 'integer'],
            'image_id' => ['integer']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the item product functions
     * 
     * @return boolean
     */ 
    public static function itemProduct(array $data) {
        $validation = Validator::make($data, [
            'product_id' => ['required', 'integer']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the procedure functions
     * 
     * @return boolean
     */ 
    public static function procedure(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the product functions
     * 
     * @return boolean
     */ 
    public static function product(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'information' => ['mimetypes:application/pdf', 'max:10000'],
            'image_id' => ['integer']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the space functions
     * 
     * @return boolean
     */ 
    public static function space(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }
}