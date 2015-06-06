<?php

	require_once(FLOW_ABS_PATH.'core/Autoloader.php');

	$AutoLoader = new AutoLoader();
	$AutoLoader->setIncludePath(FLOW_ABS_PATH.'../');
	$AutoLoader->register();

?>