<?php

	namespace Flow\Components;

	use Flow\Ports\FloatPort;
	use Flow\Core\ComponentBase;

	class FloatComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddOutPort('Value', new FloatPort());
		}

		public function Execute()
		{
			return true;
		}
	}

?>