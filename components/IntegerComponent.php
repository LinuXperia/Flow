<?php

	namespace Flow\Components;

	use Flow\Ports\IntegerPort;
	use Flow\Core\ComponentBase;

	class IntegerComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddOutPort('Value', new IntegerPort());
		}

		public function Execute()
		{
			return true;
		}
	}

?>