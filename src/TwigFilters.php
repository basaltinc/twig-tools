<?php

namespace BasaltInc\TwigTools;

use \Twig_SimpleFilter;

class TwigFilters {

  /**
   * Creates a twig filter that removes `null` from an array.
   * @return \Twig_SimpleFilter
   */
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
