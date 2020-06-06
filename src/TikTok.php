<?php

foreach (glob(dirname(__FILE__) . '/Instagram/**/*.php') as $filename) {
  require_once $filename;
}
