<?php

	namespace Flow\Core;

	use Flow\Core\Interfaces\PortInterface;

	class PortBase extends ErrorBase implements PortInterface
	{
		protected $PortName     = null;
		protected $Value        = null;
		protected $DefaultValue = null;

		public function __construct($DefaultValue = null)
		{
			$this->DefaultValue = $DefaultValue;
		}

		public function SetPortName($Name)
		{
			if (!is_string($Name) || strlen($Name) < 1) {
				return $this;
			}

			$this->PortName = $Name;

			return $this;
		}

		public function GetPortName()
		{
			return $this->PortName;
		}

		public function SetValue($Value)
		{
			$this->Value = $Value;
		}

		public function GetValue()
		{
			return $this->Value;
		}

		public function HasValue()
		{
			return isset($this->Value);
		}

		public function ResetValue()
		{
			$this->Value = $this->DefaultValue;
		}
	}

?>