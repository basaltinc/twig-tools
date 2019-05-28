<?php

namespace BasaltInc\TwigTools;

use Webmozart\PathUtil\Path;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Namespaces {

  /**
   * Build Twig Namespace config for loaders
   * Takes same config format as Pattern Lab's Twig Namespaces plugin - https://github.com/EvanLovely/plugin-twig-namespaces
   * Returns format expected by Drupal's Component Libraries config - https://www.drupal.org/project/components
   * Perfect for passing to `self::addPathsToLoader()` below
   * @see addPathsToLoader
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

        if (!file_exists($fullPath)) {
          continue;
        }

        if (isset($settings['recursive']) && $settings['recursive']) {
          $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fullPath), RecursiveIteratorIterator::SELF_FIRST);
          foreach ($items as $key => $item) {
            if ($item->isDir()) {
              $newPaths[] = $item->getPath();
            }
          }
        } else {
          $newPaths[] = $fullPath;
        }
      }
      $newPaths = array_unique($newPaths);
      if (count($newPaths) > 0) {
        $namespaces[$namespace]['paths'] = $newPaths;
      }
    }
    return $namespaces;
  }

  /**
   * Add Twig Namespaces config to new Twig_Loader_Filesystem
   * Takes same format as Drupal's Component Libraries config - https://www.drupal.org/project/components
   * @param array $config
   * @example
   *   $config = [
   *      'namespace' => [
   *          'paths' => [
   *             'path/to/templates1',
   *             'path/to/templates2',
   *           ],
   *       ]
   *   ];
   * @return \Twig_Loader_Filesystem
   */
  public static function addPathsToLoader($config) {
    $loader = new \Twig_Loader_Filesystem();
    foreach ($config as $key => $value) {
      foreach ($value['paths'] as $path) {
        $loader->addPath($path, $key);
      }
    }
    return $loader;
  }
}
