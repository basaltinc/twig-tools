<?php

namespace BasaltInc\TwigTools;

use \Twig_SimpleFunction;

class TwigFunctions {

  public static function get_data($name = 'get_data') {
    return new Twig_SimpleFunction($name, function (...$params) {
      return Utils::getDataViaTwig(...$params);
    }, [
      'needs_environment' => true,
    ]);
  }

  public static function validate_data_schema($name = 'validate_data_schema') {
    return new Twig_SimpleFunction($name, function (...$params) {
      return DataSchema::validateDataSchema(...$params);
    }, [
      'needs_environment' => true,
      'needs_context' => true,
    ]);
  }

  public static function console_log($name = 'console_log') {
    return new Twig_SimpleFunction($name, function ($data) {
      return Utils::consoleLog($data);
    });
  }

}
