<?php

	namespace Flow\Components;

	use Flow\Ports\ArrayPort;
	use Flow\Ports\FloatPort;
	use Flow\Core\ComponentBase;

	class AdditionComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Values', new ArrayPort());
			$this->AddOutPort('Value', new FloatPort());
		}

		public function Execute()
		{
			$Value = 0;
			$Values = $this->GetInput('Values');

			for ($i = 0; $i < count($Values); $i++) {
				$Value += $Values[$i];
			}

			$this->SetOutput('Value', $Value);

			return true;
		}
	}

	?>