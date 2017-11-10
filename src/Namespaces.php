<?php

namespace BasaltInc\TwigTools;

use Webmozart\PathUtil\Path;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Namespaces {

  /**
   * @param array $config
   * @param string $pathRoot - Prefix all paths with this path.
   * @return array
   */
  public static function buildLoaderConfig($config, $pathRoot) {
    $namespaces = [];
    foreach ($config as $namespace => $settings) {
      $newPaths = [];
      foreach ($settings['paths'] as $path) {
        $fullPath = Path::join($pathRoot, $path);
        if (isset($settings['recursive']) && $settings['recursive']) {
          $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fullPath), RecursiveIteratorIterator::SELF_FIRST);
          foreach ($items as $key => $item) {
            if ($item->isDir()) {
              $newPaths[] = $item->getPath();
            }
          }
        } else {
          $newPaths[] = $path;
        }
      }
      $newPaths = array_unique($newPaths);
      if (count($newPaths) > 0) {
        $namespaces[$namespace]['paths'] = $newPaths;
      }
    }
    return $namespaces;
  }
}
