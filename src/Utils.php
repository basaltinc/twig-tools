<?php

namespace BasaltInc\TwigTools;

use Symfony\Component\Yaml\Yaml;

class Utils {

  /**
   * @param {string} $full_path - Absolute or relative (from CWD) path to a JSON or Yaml file
   * @return array - Data file decoded
   * @throws \Exception
   */
  public static function getData($full_path) {
    $file_data = [];

    if ($full_path !== '' && file_exists($full_path)) {
      $file_string = file_get_contents($full_path);
      $file_type = pathinfo($full_path)['extension'];

      switch ($file_type) {
        case 'json':
          $file_data = json_decode($file_string, true);
          break;
        case 'yaml' || 'yml':
          $file_data = Yaml::parse($file_string);
          break;
      }
    } else {
      throw new \Exception('Cannot find file when trying to run get_file_data: ' . $full_path);
    }
    return $file_data;
  }

  /**
   * @param {Twig_Environment} $env
   * @param {string} $templateName
   * @return {string} $full_path - Full path to where the Twig file resides
   * @throws \Exception
   */
  public static function resolveTwigPath(\Twig_Environment $env, $templateName) {
    /**
     * @var \Twig_Template $template
     * @url https://twig.symfony.com/api/1.x/Twig_Template.html
     * */
    $template = $env->resolveTemplate($templateName);

    /**
     * @var \Twig_Source $source
     * @url https://twig.symfony.com/api/1.x/Twig_Source.html
     */
    $source = $template->getSourceContext();

    /** @var string $full_path */
    $full_path = $source->getPath();
    if (!file_exists($full_path)) {
      throw new \Exception('Resolved Twig File does not exist, given `' . $templateName . '`, found path `' . $full_path . '`.');
    }
    return $full_path;
  }

  /**
   * @param \Twig_Environment $env
   * @param {string} $path - Either absolute path, relative path from CWD, or Twig Namespace path like `@namespace/file.json`
   * @return array - `file.json` turned into data
   * @throws \Exception
   */
  public static function getDataViaTwig(\Twig_Environment $env, $path) {
    // If it's a file path, just use that, if not, then use Twig to resolve it.
    $full_path = is_file($path) ? $path : Utils::resolveTwigPath($env, $path);
    $file_data = Utils::getData($full_path);
    return $file_data;
  }


  /**
   * @param array $data - Data to show in Browser's console
   * @param string $type - Method on JS `console` to call: one of 'log, error, info', used. i.e. Passing `error` calls `console.error`
   * @param array $toLog - Properties on `$data` to log
   * @param bool $refPrevElement - If it should reference the previous HTML element
   * @return string
   */
  public static function consoleLog($data, $type = 'log', $toLog = [], $refPrevElement = false) {
    $logArgs = [];
    if ($toLog) {
      foreach ($toLog as $arg) {
        $logArgs[] = 'data.' . $arg;
      }
    } else {
      $logArgs[] = 'data';
    }

    $output = '
<script type="application/json">' . json_encode($data) . '</script>
<script>
	(function () {
	  if (document.currentScript) {
      var me = document.currentScript;
      var jsonScriptTag = me.previousElementSibling.innerHTML;
      var data = JSON.parse(jsonScriptTag);';

      if ($refPrevElement) {
        $output = $output . 'var prevElement = me.previousElementSibling.previousElementSibling;';
        $logArgs[] = 'prevElement';
      }

      $consoleStatement = 'console.' . $type . '(' . join(', ', $logArgs) . ');';

      $output = $output . $consoleStatement . '
	  }
	})();
</script>
	';
    return $output;
  }

}
