<?php

namespace BasaltInc\TwigTools\TwigExtensions;

use BasaltInc\TwigTools\TwigFunctions;

class BasaltBasicsExtension extends \Twig_Extension implements \Twig_ExtensionInterface {

  public function getFunctions() {
    return [
        TwigFunctions::get_data(),
    ];
  }

}
