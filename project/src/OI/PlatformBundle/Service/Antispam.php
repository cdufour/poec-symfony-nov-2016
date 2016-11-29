<?php

namespace OI\PlatformBundle\Service;

class Antispam
{
  private $minLength;

  public function __construct($minLength) {
    $this->minLength = $minLength;
  }
  public function isSpam($text)
  {
    return strlen($text) < $this->minLength;
  }
}
