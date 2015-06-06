<?php

	namespace Flow\Components;

	use Flow\Ports\BooleanPort;
	use Flow\Core\ComponentBase;

	class BooleanComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Value', new BooleanPort());
			$this->AddOutPort('Value', new BooleanPort());
		}

		public function Execute()
		{
			$Value = $this->GetInput('Value');
			$this->SetOutput('Value', $Value);

			return true;
		}
	}

?>