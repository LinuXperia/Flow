<?php

	namespace Flow\Core\Interfaces;

	interface NetworkInterface
	{
		public static function &GetInstance($GraphName);
		public function AddNode($NodeName, ComponentInterface $Node);
		public function HasNode($NodeName);
		public function RemoveNode($NodeName);
		public function AddConnection($OutNodeName, $OutPortName, $InNodeName, $InPortName);
		public function Execute();
	}

?>