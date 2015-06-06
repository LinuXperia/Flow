<?php

	namespace Flow\Components;

	use Flow\Ports\StringPort;
	use Flow\Core\ComponentBase;

	class EchoComponent extends ComponentBase
	{
		public function Initialize()
		{
			$this->AddInPort('Text', new StringPort());
		}

		public function Execute()
		{
			try
			{
				echo $this->GetInput('Text');
			}
			catch (\Exception $Exception)
			{
				$this->AddError("Unable to echo the value.");
				return false;
			}

			return true;
		}
	}

	?>