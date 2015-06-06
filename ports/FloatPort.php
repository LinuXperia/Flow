<?php
	
	namespace Flow\Ports;

	use Flow\Core\PortBase;

	class FloatPort extends PortBase
	{
		public function SetValue($Value)
		{
			try
			{
				$this->Value = floatval($Value);
			}
			catch (\Exception $Exception)
			{
				$Type = gettype($Value);
				$this->AddError("Cannot convert {$Type} to a float value.");

				return false;
			}

			return true;
		}

		public function GetValue()
		{
			if (!is_float($this->Value)) {
				return null;
			}

			return $this->Value;
		}

		public function HasValue()
		{
			return is_float($this->Value);
		}
	}

?>