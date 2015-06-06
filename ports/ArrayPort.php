<?php
	
	namespace Flow\Ports;

	use Flow\Core\PortBase;

	class ArrayPort extends PortBase
	{
		public function __construct($DefaultValue = array())
		{
			$this->Value        = array();
			$this->DefaultValue = is_array($DefaultValue) ? $DefaultValue : array();
		}

		public function SetValue($Value)
		{
			try
			{
				array_push($this->Value, $Value);
			}
			catch (\Exception $Exception)
			{
				$Type = gettype($Value);
				$this->AddError("Cannot convert {$Type} to an array value.");

				return false;
			}

			return true;
		}

		public function GetValue()
		{
			if (!is_array($this->Value)) {
				return null;
			}

			return $this->Value;
		}

		public function HasValue()
		{
			return is_bool($this->Value);
		}
	}

?>