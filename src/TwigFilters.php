<?php

namespace BasaltInc\TwigTools;

use \Twig_SimpleFilter;

class TwigFilters {

  public static function remove_null($name = 'remove_null') {
    return new Twig_SimpleFilter($name, function ($array) {
      $result = [];
      foreach ($array as $value) {
        if ($value !== null) {
          $result[] = $value;
        }
      }
      return $result;
    });
  }

}
