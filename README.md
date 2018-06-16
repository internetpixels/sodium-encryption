# Sodium PHP encryption library

Protect your data and secure every field in your entities with this tiny encryption library!

This is a open-source library. Please consider a link to this repository when you're actively using it.

[![License](https://camo.githubusercontent.com/cf76db379873b010c163f9cf1b5de4f5730b5a67/68747470733a2f2f6261646765732e66726170736f66742e636f6d2f6f732f6d69742f6d69742e7376673f763d313032)](https://github.com/internetpixels/csrf-protection)
[![Build Status](https://travis-ci.org/internetpixels/sodium-encryption.svg)](https://travis-ci.org/internetpixels/csrf-protection)
[![Maintainability](https://api.codeclimate.com/v1/badges/d0d817a21ca7243433b3/maintainability)](https://codeclimate.com/github/internetpixels/sodium-encryption)

## Install with composer
This small encryption/decryption library can be required by using composer. Please use the following command:

```text
composer require internetpixels/sodium-encryption
```

### Setup the TokenManager
You have to set the ``secret`` and ``pubic`` tokens once. Those keys are not allowed to change overtime! 
```php
<?php
// Update the keys to your own!
\InternetPixels\SodiumEncryption\EncryptionManager::setKeys(
    '1d17336ba7b2cec7dc8ec788e78ebf835d9f85cfc414275e92fd8e3ae5d6d2b6',
    'b88fc95850eec82492e9f0616cfeb69b9205735e34f5ce5e83d681eb38147d57'
);
```

### Encrypt a field
We advise you to create a unique nonce per entity (use the ``EncryptionManager::generateNonce()`` method). You'll have to save the nonce with your data too, because it will be used when you want to decrypt the data again.
```php
<?php
$string = 'This is my default text string with 88 numbers!';
$nonce = EncryptionManager::generateNonce();

$encrypted = EncryptionManager::encrypt($string, $nonce);
```

### Decrypt a field
In order to decrypt a field, you'll need the encrypted string and the nonce.
```php
<?php
$string = EncryptionManager::decrypt($encrypted, $nonce);
```

