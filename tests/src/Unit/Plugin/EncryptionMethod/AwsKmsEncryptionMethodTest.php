<?php

namespace Drupal\Tests\encrypt_kms\Unit\Plugin\EncryptionMethod;

use Drupal\Tests\UnitTestCase;
use Psr\Log\LoggerInterface;

/**
 * Unit tests for AwsKmsEncryptionMethod.
 *
 * @coversDefaultClass \Drupal\encrypt_kms\Plugin\EncryptionMethod\AwsKmsEncryptionMethod
 * @group encrypt_kms
 */
class AwsKmsEncryptionMethodTest extends UnitTestCase {

  protected $runTestInSeparateProcess = TRUE;

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $logger;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->logger = $this->getMock(LoggerInterface::class);

  }

  /**
   * Tests the test.
   *
   * @covers ::foo
   */
  public function testFoo() {
    $this->assert(TRUE);
  }

}
