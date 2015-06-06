<?php

	namespace Flow\Components;

	use Flow\Ports\FloatPort;
	use Flow\Core\ComponentBase;

	class FloatComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Value', new FloatPort());
			$this->AddOutPort('Value', new FloatPort());
		}

		public function Execute()
		{
			$Value = $this->GetInput('Value');
			$this->SetOutput('Value', $Value);

			return true;
		}
	}

?>