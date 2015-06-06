<?php

	namespace Flow\Ports;

	use Flow\Core\PortBase;

	class StringPort extends PortBase
	{
		public function SetValue($Value)
		{
			try
			{
				$this->Value = (string) $Value;
			}
			catch (\Exception $Exception)
			{
				$Type = gettype($Value);
				$this->AddError("Cannot convert {$Type} to a string value.");

				return false;
			}

			$this->Value = $Value;

			return true;
		}

		public function GetValue()
		{
			return $this->Value;
		}

		public function HasValue()
		{
			return is_string($this->Value);
		}
	}

?>