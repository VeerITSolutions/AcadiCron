<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

class EncLib
{
    private $pub_key = 'ss@pubkey';
    private $pvt_key = 'ss@pvtkey';



    /**
     * Encrypt a string using AES-256-CBC
     */
    public function encrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }

    /**
     * Decrypt a string using AES-256-CBC
     */
    public function decrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    /**
     * Hash a password using Laravel's bcrypt hashing
     */
    public function passHashEnc($password)
    {
        return Hash::make($password);
    }

    /**
     * Verify a hashed password
     */
    public function passHashDyc($password, $hashedPassword)
    {
        return Hash::check($password, $hashedPassword);
    }




    public function generateRandomPassword($length = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';

        if ($use_upper_case) {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($include_numbers) {
            $characters .= '0123456789';
        }

        if ($include_special_chars) {
            $characters .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        }

        return substr(str_shuffle($characters), 0, $length);
    }
}
