<?php

namespace InternetPixels\SodiumEncryption;

/**
 * Class EncryptionManager
 * @package InternetPixels\SodiumEncryption
 */
class EncryptionManager
{

    /**
     * @var string
     */
    private static $secret;

    /**
     * @var string
     */
    private static $public;

    /**
     * Encrypt a string with a given nonce.
     *
     * @param $string
     * @param $nonce
     * @return string
     */
    public static function encrypt($string, $nonce)
    {
        $messageKeyPair = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            sodium_hex2bin(self::$secret),
            sodium_hex2bin(self::$public)
        );

        $cipherText = sodium_crypto_box(
            $string,
            sodium_hex2bin($nonce),
            $messageKeyPair
        );

        $encrypted = sodium_bin2hex($cipherText);

        return $encrypted;
    }

    /**
     * Decrypt an encryption entity
     *
     * @param string $encrypted
     * @param string $nonce
     * @return string
     */
    public static function decrypt(string $encrypted, string $nonce)
    {
        $messageKeyPair = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            sodium_hex2bin(self::$secret),
            sodium_hex2bin(self::$public)
        );

        $string = sodium_crypto_box_open(
            sodium_hex2bin($encrypted),
            sodium_hex2bin($nonce),
            $messageKeyPair
        );

        return $string;
    }

    /**
     * Generate a hexidecimal nonce.
     *
     * @return string
     * @throws \Exception
     */
    public static function generateNonce()
    {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);

        return \sodium_bin2hex($nonce);
    }

    /**
     * Set the keys for improved encryption levels.
     *
     * @param string $secret
     * @param string $public
     * @throws \Exception
     */
    public static function setKeys(string $secret, string $public)
    {
        if (strlen($secret) !== 64 || strlen($public) !== 64) {
            throw new \Exception('The keys must be 64 chars (a-z, 0-9) long!');
        }

        self::$secret = $secret;
        self::$public = $public;
    }

}