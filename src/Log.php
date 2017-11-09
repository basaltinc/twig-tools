<?php

namespace Basalt\TwigTools;

class Log {

  /**
   * @param array $data
   * @return string
   */
  public function console($data) {
    $output = '
<script type="application/json">' . json_encode($data) . '</script>
<script>
	(function () {
		var me = document.currentScript;
		var jsonScriptTag = me.previousElementSibling.innerHTML;
		var data = JSON.parse(jsonScriptTag);
		console.log(data);
	})();
</script>
	';
    return $output;
  }
}
