<?php

	namespace Flow\Core\Interfaces;

	interface ComponentInterface
	{
		public function GetName();
		public function SetName($ComponentName);
		public function HasInPort($PortName);
		public function HasOutPort($PortName);
		public function SetInput($PortName, $Value);
		public function GetInput($PortName);
		public function GetOutput($PortName);
		public function IsStateful($IsStateful = false);
		public function ResetComponent();
		public function Initialize();
		public function Execute();
	}

?>