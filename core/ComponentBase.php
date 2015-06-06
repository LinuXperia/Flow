<?php

	namespace Flow\Core;

	use Flow\Core\Interfaces\PortInterface;
	use Flow\Core\Interfaces\ComponentInterface;

	abstract class ComponentBase extends ErrorBase implements ComponentInterface
	{
		protected $Name;

		/**
		 * List of the available incoming ports.
		 *
		 * @var PortInterface[]
		 */
		protected $_InPorts = array();

		/**
		 * List of the available outgoing ports.
		 *
		 * @var PortInterface[]
		 */
		protected $_OutPorts = array();

		/**
		 * Tells whether this component will keep its state when finished.
		 *
		 * @var bool
		 */
		protected $_IsStateful = true;

		public function SetName($ComponentName)
		{
			if (!is_string($ComponentName) && !is_integer($ComponentName)) {
				return false;
			}

			$this->Name = $ComponentName;

			return true;
		}

		public function GetName()
		{
			return $this->Name;
		}

		public function HasInPort($PortName)
		{
			if (!is_string($PortName) && !is_integer($PortName)) {
				return false;
			}

			if (!isset($this->_InPorts[$PortName])) {
				return false;
			}

			return $this->_InPorts[$PortName] instanceof PortInterface;
		}

		public function HasOutPort($PortName)
		{
			if (!is_string($PortName) && !is_integer($PortName)) {
				return false;
			}

			if (!isset($this->_OutPorts[$PortName])) {
				return false;
			}

			return $this->_OutPorts[$PortName] instanceof PortInterface;
		}

		protected function AddInPort($PortName, PortInterface $Port)
		{
			if ((!is_string($PortName) || strlen($PortName) < 1) && !is_integer($PortName)) {
				return $this;
			}

			if (!$Port->SetPortName($PortName)) {
				return $this;
			}

			$this->_InPorts[$PortName] = $Port;

			return $this;
		}

		protected function AddOutPort($PortName, PortInterface $Port)
		{
			if ((!is_string($PortName) || strlen($PortName) < 1) && !is_integer($PortName)) {
				return $this;
			}

			$Port->SetPortName($PortName);

			$this->_OutPorts[$PortName] = $Port;

			return $this;
		}

		public function SetInput($PortName, $Value)
		{
			if (!$this->HasInPort($PortName)) {
				return false;
			}

			$this->_InPorts[$PortName]->SetValue($Value);

			return true;
		}

		protected function SetOutput($PortName, $Value)
		{
			if (!$this->HasOutPort($PortName)) {
				return $this;
			}

			$this->_OutPorts[$PortName]->SetValue($Value);

			return $this;
		}

		public function GetInput($PortName)
		{
			if (!$this->HasInPort($PortName)) {
				return null;
			}

			return $this->_InPorts[$PortName]->GetValue();
		}

		public function GetOutput($PortName)
		{
			if (!$this->HasOutPort($PortName)) {
				return null;
			}

			return $this->_OutPorts[$PortName]->GetValue();
		}

		public function IsStateful($IsStateful = null)
		{
			if ($IsStateful === null) {
				return $this->_IsStateful;
			}

			$this->_IsStateful = (bool) $IsStateful;

			return true;
		}

		public function ResetComponent()
		{
			$this->ResetPorts();

			return true;
		}

		protected function ResetPorts()
		{
			foreach (array_keys($this->_InPorts) as $PortName) {
				$this->_InPorts[$PortName]->ResetValue();
			}

			foreach (array_keys($this->_OutPorts) as $PortName) {
				$this->_OutPorts[$PortName]->ResetValue();
			}
		}

		public function Initialize()
		{
			return true;
		}

		public abstract function Execute();
	}