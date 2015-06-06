<?php
	
	namespace Flow\Ports;

	use Flow\Core\PortBase;

	class IntegerPort extends PortBase
	{
		public function SetValue($Value)
		{
			try
			{
				$this->Value = intval($Value);
			}
			catch (\Exception $Exception)
			{
				$Type = gettype($Value);
				$this->AddError("Cannot convert {$Type} to an integer value.");

				return false;
			}

			return true;
		}

		public function GetValue()
		{
			if (!is_integer($this->Value)) {
				return null;
			}

			return $this->Value;
		}

		public function HasValue()
		{
			return is_integer($this->Value);
		}
	}

?>