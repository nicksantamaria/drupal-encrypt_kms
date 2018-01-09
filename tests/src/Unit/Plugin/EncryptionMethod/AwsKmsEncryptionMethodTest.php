<?php

namespace Drupal\Tests\encrypt_kms\Unit\Plugin\EncryptionMethod;

use Drupal\Tests\UnitTestCase;
use Psr\Log\LoggerInterface;
use Aws\Kms\KmsClient;
use Aws\Result;
use Drupal\encrypt_kms\Plugin\EncryptionMethod\AwsKmsEncryptionMethod;

/**
 * Unit tests for AwsKmsEncryptionMethod.
 *
 * @coversDefaultClass \Drupal\encrypt_kms\Plugin\EncryptionMethod\AwsKmsEncryptionMethod
 * @group encrypt_kms
 */
class AwsKmsEncryptionMethodTest extends UnitTestCase {

  /**
   * The encryption method service.
   *
   * @var \Drupal\encrypt\EncryptionMethodInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $encryptionMethod;

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $logger;

  /**
   * The KMS Client.
   *
   * @var \Aws\Kms\KmsClient|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $kmsClient;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->logger = $this->getMock(LoggerInterface::class);
    $this->kmsClient = $this->getMockBuilder(KmsClient::class)
      ->disableOriginalConstructor()
      ->setMethods(['encrypt', 'decrypt'])
      ->getMock();
    $this->encryptionMethod = new AwsKmsEncryptionMethod([], '', '');
    $this->encryptionMethod->setKmsClient($this->kmsClient);
    $this->encryptionMethod->setLogger($this->logger);
  }

  /**
   * Tests encrypt method.
   *
   * @covers ::encrypt
   */
  public function testEncrypt() {
    $result = new Result([
      'CiphertextBlob' => 'CIPHERTEXT_BLOB',
    ]);

    $this->kmsClient->expects($this->once())
      ->method('encrypt')
      ->withAnyParameters()
      ->willReturn($result);

    $text = 'the quick brown fox';
    $key = 'arn:aws:kms:us-west-2:111122223333:key/1234abcd-12ab-34cd-56ef-1234567890ab';

    $ciphertext = $this->encryptionMethod->encrypt($text, $key);

    $this->assertEquals('CIPHERTEXT_BLOB', $ciphertext);
  }

  /**
   * Tests decrypt method.
   *
   * @covers ::decrypt
   */
  public function testDecrypt() {
    $result = new Result([
      'Plaintext' => 'the quick brown fox',
    ]);

    $this->kmsClient->expects($this->once())
      ->method('decrypt')
      ->withAnyParameters()
      ->willReturn($result);

    $ciphertext = 'CIPHERTEXT_BLOB';
    $key = 'arn:aws:kms:us-west-2:111122223333:key/1234abcd-12ab-34cd-56ef-1234567890ab';

    $text = $this->encryptionMethod->decrypt($ciphertext, $key);

    $this->assertEquals($text, $ciphertext);
  }

}
