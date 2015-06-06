<?php

	namespace Flow\Components;

	use Flow\Ports\StringPort;
	use Flow\Core\ComponentBase;

	class StringComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Text', new StringPort());
			$this->AddOutPort('Text', new StringPort());
		}

		public function Execute()
		{
			$Value = $this->GetInput('Text');
			$this->SetOutput('Text', $Value);

			return true;
		}
	}

?>