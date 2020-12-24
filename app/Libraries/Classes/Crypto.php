<?php
namespace App\Libraries\Classes;

/**
 * Encrypt and Decrypt class using openssl
 */
class Crypto{
    const METHOD = 'AES-256-CBC';

    /**
     * Encrypts (but does not authenticate) a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded 
     * @return string (raw binary)
     */
    public static function encrypt($message, $encode = true)
    {
        $key=KEY;
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        try{
         $ciphertext = @openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
         );
         $sendEncrypt=$nonce.$ciphertext;
         if(!$ciphertext)throw new \Exception('');
        }catch(\Exception $e){
            $encode=false;
            $sendEncrypt=$e->getMessage();
        }

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            $sendEncrypt=base64_encode($sendEncrypt);
        }
        return $sendEncrypt;
    }

    /**
     * Decrypts (but does not verify) a message
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public static function decrypt($message, $encoded = true){
        $key=KEY;
        try{
            if ($encoded) {
                $message = @base64_decode($message, true);
            }
            if ($message === false) {
                throw new \Exception('');
            }else{
                $nonceSize = openssl_cipher_iv_length(self::METHOD);
                $nonce = mb_substr($message, 0, $nonceSize, '8bit');
                $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

                $plaintext = @openssl_decrypt(
                    $ciphertext,
                    self::METHOD,
                    $key,
                    OPENSSL_RAW_DATA,
                    $nonce
                );
            }
        }catch(\Exception $e){
            $plaintext=$e->getMessage();
        }

        return $plaintext;
    }
}