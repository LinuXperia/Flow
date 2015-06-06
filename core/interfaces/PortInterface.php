<?php

	namespace Flow\Core\Interfaces;

	interface PortInterface
	{
		public function SetPortName($PortName);
		public function SetValue($Value);
		public function GetValue();
		public function HasValue();
		public function ResetValue();
	}