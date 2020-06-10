<?php

namespace TikTok\Core\Libraries;

/**
 * Handles the signing of a url.
 *
 * @TODO: Not everyone will want to have to
 * install Node. Therefore, I should also allow
 * a public endpoint to a hosted domain that does the signing
 * as well. Will setup soon.
 */
class Signer {

  /**
   * Executes the node script that generates the
   * url signature.
   */
  public static function execute($url, $userAgent) {

    // Set node path
    $node = VENDOR_BIN_PATH . 'node';

    // Set the script path
    $script = __DIR__ . '/../Node/GenerateSignature.js';

    // If node does not exist, throw an exception
    if (!file_exists($node)) throw new \Exception('Node file does not exist');

    // Build the command to be ran
    $command = "$node $script --url=\"$url\" --userAgent=\"$userAgent\"";

    // Execute the command
    exec($command, $output, $returnVariable);

    // If output is not provided, return false
    if (!isset($output[0])) return false;

    // Return the url and signature
    return [
      'url' => "$url&_signature=" . $output[0],
      'signature' => $output[0],
      'userAgent' => $userAgent
    ];
  }
}
