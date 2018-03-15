<?php

namespace BasaltInc\TwigTools;

use \Twig_SimpleFilter;

class TwigFilters {

  public static function remove_null($name = 'remove_null') {
    return new Twig_SimpleFilter($name, function ($array) {
      if (!is_array($array)) {
        return $array;
      }
      return array_filter($array, function($item) {
        return $item !== null;
      });
    });
  }

}
