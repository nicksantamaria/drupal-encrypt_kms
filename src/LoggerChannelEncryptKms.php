<?php

namespace Drupal\encrypt_kms;

use Drupal\Core\Logger\LoggerChannel;

/**
 * Defines a logger channel for encrypt_kms.
 *
 * The key feature of this class is the ability to redact sensitive information
 * from log messages.
 */
class LoggerChannelEncryptKms extends LoggerChannel {

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []) {
    // Users of this logger channel can redact sensitive information from log
    // messages by passing the 'sensitive_data' context.
    if (!empty($context['sensitive_data'])) {
      $placeholder = '***';
      $message = str_replace($context['sensitive_data'], $placeholder, $message);
    }
    parent::log($level, $message, $context);
  }

}
