<?php


namespace App\Modules;


class CryptoOpenSSL
{
    const CIPHER = 'AES-128-CBC';

    public static function encrypt($ENCRYPTION_KEY, string $text): String {
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($text, self::CIPHER, $ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $ENCRYPTION_KEY, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }

    public static function decrypt($ENCRYPTION_KEY, string $text): String{
        $c = base64_decode($text);
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $plaintext = openssl_decrypt($ciphertext_raw, self::CIPHER, $ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $ENCRYPTION_KEY, $as_binary = true);
        if (hash_equals($hmac, $calcmac))
            return $plaintext;
        else
            return '';
    }
}
