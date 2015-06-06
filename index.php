<?php

	define('FLOW_REL_PATH', './');
	define('FLOW_ABS_PATH', rtrim(dirname(__FILE__), '/\\').'/');
	define('FLOW_GRAPH_FOLDER', FLOW_ABS_PATH.'graphs');

	require_once(FLOW_REL_PATH.'core/Bootstrap.php');

	if (($Network = Flow\Core\Network::GetInstance('FlowDefault')) === false) {
		die("Unable to load the graph.");
	}

	$Network->Execute();

?>