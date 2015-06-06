<?php
	
	namespace Flow\Ports;

	use Flow\Core\PortBase;

	class BooleanPort extends PortBase
	{
		public function SetValue($Value)
		{
			try
			{
				$this->Value = boolval($Value);
			}
			catch (\Exception $Exception)
			{
				$Type = gettype($Value);
				$this->AddError("Cannot convert {$Type} to a boolean value.");

				return false;
			}

			return true;
		}

		public function GetValue()
		{
			if (!is_bool($this->Value)) {
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