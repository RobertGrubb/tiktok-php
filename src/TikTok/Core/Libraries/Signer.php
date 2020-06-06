<?php

namespace TikTok\Core\Libraries;

class Signer {

  /**
   * Executes the node script that generates the
   * url signature.
   */
  public static function execute($url, $userAgent) {
    $node = VENDOR_BIN_PATH . 'node';
    $script = __DIR__ . '/../Node/GenerateSignature.js';

    // If node does not exist, throw an exception
    if (!file_exists($node)) throw new \Exception('Node file does not exist');

    // Build the command to be ran
    $command = "$node $script --url=\"$url\"";

    // Execute the command
    exec($command, $output, $returnVariable);

    if (!isset($output[0])) return false;

    return [
      'url' => "$url&_signature=" . $output[0],
      'signature' => $output[0]
    ];
  }
}
