<?php

	namespace Flow\Components;

	use Flow\Ports\BooleanPort;
	use Flow\Core\ComponentBase;

	class BooleanComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddOutPort('Value', new BooleanPort());
		}

		public function Execute()
		{
			return true;
		}
	}

?>