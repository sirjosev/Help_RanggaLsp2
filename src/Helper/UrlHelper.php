<?php
namespace App\Helper;

class UrlHelper {
    private static $cipher = "AES-256-CBC";
    
    public static function encrypt($data) {
        if (!defined('ENCRYPTION_KEY')) {
            return $data;
        }
        
        $key = ENCRYPTION_KEY;
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, self::$cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        
        // Make it URL safe
        return str_replace(['+', '/', '='], ['-', '_', ''], $ciphertext);
    }

    public static function decrypt($data) {
        if (!defined('ENCRYPTION_KEY')) {
            return $data;
        }
        
        // Restore from URL safe
        $data = str_replace(['-', '_'], ['+', '/'], $data);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        
        $c = base64_decode($data);
        $key = ENCRYPTION_KEY;
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        
        if (strlen($c) <= $ivlen + 32) { // 32 is sha256 length
            return false;
        }
        
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, 32);
        $ciphertext_raw = substr($c, $ivlen + 32);
        $original_plaintext = openssl_decrypt($ciphertext_raw, self::$cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
        
        return false;
    }
}
