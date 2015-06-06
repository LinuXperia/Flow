<?php

	namespace Flow\Components;

	use Flow\Ports\IntegerPort;
	use Flow\Core\ComponentBase;

	class IntegerComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Value', new IntegerPort());
			$this->AddOutPort('Value', new IntegerPort());
		}

		public function Execute()
		{
			$Value = $this->GetInput('Value');
			$this->SetOutput('Value', $Value);

			return true;
		}
	}

?>