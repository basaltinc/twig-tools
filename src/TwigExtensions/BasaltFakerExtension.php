<?php

namespace BasaltInc\TwigTools\TwigExtensions;

use BasaltInc\TwigTools\TwigFunctions;
use BasaltInc\TwigTools\TwigFaker;
use Twig_Environment;

class BasaltFakerExtension extends \Twig_Extension implements \Twig_ExtensionInterface {

  function getName() {
    return 'BasaltFakerExtension';
  }

  function getGlobals() {
    return [
        'faker' => new TwigFaker(),
    ];
  }

  public function initRuntime(Twig_Environment $environment) {

  }
}
