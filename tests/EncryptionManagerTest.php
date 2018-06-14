<?php

namespace InternetPixels\SodiumEncryption\Tests;

use InternetPixels\SodiumEncryption\EncryptionManager;
use PHPUnit\Framework\TestCase;

/**
 * Class EncryptionManagerTest
 * @package InternetPixels\SodiumEncryption\Tests
 */
class EncryptionManagerTest extends TestCase
{

    public function setUp()
    {
        EncryptionManager::setKeys(
            '1d17336ba7b2cec7dc8ec788e78ebf835d9f85cfc414275e92fd8e3ae5d6d2b6',
            'b88fc95850eec82492e9f0616cfeb69b9205735e34f5ce5e83d681eb38147d57'
        );
    }

    public function testEncrypt()
    {
        $string = 'This is my default text string with 88 numbers!';
        $nonce = EncryptionManager::generateNonce();

        $result = EncryptionManager::encrypt($string, $nonce);

        $this->assertNotEquals($string, $result);
        $this->assertNotContains(' ', $result);
    }

    public function testDecrypt()
    {
        $string = 'This is my default text string with 88 numbers!';
        $nonce = EncryptionManager::generateNonce();

        $result = EncryptionManager::encrypt($string, $nonce);
        $this->assertNotEquals($string, $result);

        $result = EncryptionManager::decrypt($result, $nonce);
        $this->assertEquals($string, $result);
    }

    public function testDecrypt_WITH_longString_AND_specialChars()
    {
        $string = "Frysluš bombygrač břoul dinět lipry bles sléť úše a nědni. Ni mlusít sreskvě važ trkývudě tidi bléský tiš gročá dimu škeť flogími. Prak tať nigýť dězlyti flask píp úre tičást sli. Chromrýdichra zryšli diď zkep tědim. ši myj bložzký z ža uskeť ptuz ňálka bocdě děh, námřu moň tletarfek zrémafle dřastmě tiř přenýd věrglous těd. V zkoclí volclouvo. ";
        $string .= "Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name. Birds taught me to sing, when they took me to their king, first I had to fly, in the sky so high so high, so high so high so high, so - if you want to sing this way, think of what you'd like to say, add a tune and you will see, just how easy it can be. Treacle pudding, fish and chips, fizzy drinks and liquorice, flowers, rivers, sand and sea, snowflakes and the stars are free. La la la la la, la la la la la la la, la la la la la la la, la la la la la la la la la la la la la, so - Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name.";
        $nonce = EncryptionManager::generateNonce();

        $result = EncryptionManager::encrypt($string, $nonce);
        $this->assertNotEquals($string, $result);

        $result = EncryptionManager::decrypt($result, $nonce);
        $this->assertEquals($string, $result);
    }

    public function testDecrypt_WITH_wrongNonce()
    {
        $string = 'This is my default text string with 88 numbers!';
        $nonce = EncryptionManager::generateNonce();

        $result = EncryptionManager::encrypt($string, $nonce);
        $this->assertNotEquals($string, $result);

        $result = EncryptionManager::decrypt($result, EncryptionManager::generateNonce());
        $this->assertNotEquals($string, $result);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The keys must be 64 chars (a-z, 0-9) long!
     * @throws \Exception
     */
    public function testSetKeys_WTH_ToLessChars()
    {
        EncryptionManager::setKeys(
            '1d17336ba7b2cec7dc8ec788e78ebf835d9f85cfc414275e92fd8e3ae5d66',
            'b88fc95850eec82492e9f0616cfeb69b9205735e34f5ce5e83d8147d57'
        );
    }

}