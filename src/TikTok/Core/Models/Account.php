<?php

namespace Instagram\Core\Models;

class Account
{

  /**
   * Convert from an Page
   */
  public function convert ($user) {
    $instance = new self();
    return $instance;
  }
}
