<?php

	define('FLOW_REL_PATH', './');
	define('FLOW_ABS_PATH', rtrim(dirname(__FILE__), '/\\').'/');
	define('FLOW_GRAPH_FOLDER', FLOW_ABS_PATH.'graphs');

	require_once(FLOW_REL_PATH.'core/Bootstrap.php');

	if (!isset($_REQUEST['Flow'])) {
		$_REQUEST['Flow'] = 'FlowDefault';
	}

	if (($Network = Flow\Core\Network::GetInstance($_REQUEST['Flow'])) === false) {
		die("Unable to load the graph.");
	}

	$Network->Execute();

?>