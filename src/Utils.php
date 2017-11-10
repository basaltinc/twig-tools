<?php

namespace BasaltInc\TwigTools;

use Symfony\Component\Yaml\Yaml;

class Utils {

  /**
   * @param string $path - Path to JSON or Yaml file
   * @return array $data - That file as data
   */
  public static function getData($path) {
    $data = [];
    if (!is_file($path)) {
      // @todo Implement better error reporting.
      return [
          'message' => 'Error! File not found at ' . $path,
      ];
    }

    $file_string = file_get_contents($path);
    $file_type = pathinfo($path)['extension'];

    switch ($file_type) {
      case 'json':
        $data = json_decode($file_string, true);
        break;
      case 'yaml' || 'yml':
        $data = Yaml::parse($file_string);
        break;
    }
    return $data;
  }
}
