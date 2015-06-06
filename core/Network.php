<?php

	namespace Flow\Core;

	use SimpleXMLElement;
	use Flow\Core\Interfaces\NetworkInterface;
	use Flow\Core\Interfaces\ComponentInterface;

	class Network implements NetworkInterface
	{
		/**
		 * @var ComponentInterface[]
		 */
		protected $Nodes          = array();
		protected $InConnections  = array();
		protected $OutConnections = array();
		protected $CurrentNode    = null;

		protected static $_Instances = array();

		/**
		 * @param null $GraphName
		 *
		 * @return Network|false
		 */
		public static function &GetInstance($GraphName = null)
		{
			if (!isset(self::$_Instances[$GraphName]) || (self::$_Instances[$GraphName] instanceof NetworkInterface) === false) {
				self::$_Instances[$GraphName] = Network::LoadFromGraph($GraphName);
			}

			return self::$_Instances[$GraphName];
		}

		public static function LoadFromGraph($GraphName)
		{
			$FileLocation = FLOW_ABS_PATH."graphs/{$GraphName}.json";

			if (!file_exists($FileLocation)) {
				return false;
			}

			if (($Contents = @file_get_contents($FileLocation)) === false) {
				return false;
			}

			if (($Content = @json_decode($Contents, true)) === false) {
				return false;
			}

			$Network = new Network();
			$Graph   = $Content['Graph'];

			/**
			 * @var \Flow\Core\ComponentBase $Component
			 */
			if (isset($Graph['Nodes']) && is_array($Graph['Nodes'])) {
				foreach (array_values($Graph['Nodes']) as $Node) {
					$Component = new $Node['Component']();
					$Component->Initialize();
					$Component->SetName($Node['Name']);

					if (isset($Node['Inputs']) && is_array($Node['Inputs'])) {
						for ($i = 0; $i < count($Node['Inputs']); $i++) {
							$Component->SetInput($Node['Inputs'][$i]['Name'], $Node['Inputs'][$i]['Value']);
						}
					}

					$Network->AddNode($Node['Name'], $Component);
				}
			}

			if (isset($Graph['Connections']) && count($Graph['Connections']) > 0) {
				foreach (array_values($Graph['Connections']) as $Connection) {
					$Network->AddConnection(
						$Connection['OutputNode'],
						$Connection['OutputPort'],
						$Connection['InputNode'],
						$Connection['InputPort']
					);
				}
			}

			return $Network;
		}

		public function AddNode($NodeName, ComponentInterface $Node)
		{
			if ((!is_string($NodeName) || strlen($NodeName) < 1) && !is_integer($NodeName)) {
				return $this;
			}

			if ($this->CurrentNode === null) {
				$this->CurrentNode = $NodeName;
			}

			$this->Nodes[$NodeName] = $Node;

			return $this;
		}

		public function HasNode($NodeName)
		{
			if ((!is_string($NodeName) || strlen($NodeName) < 1) && !is_integer($NodeName)) {
				return $this;
			}

			return isset($this->Nodes[$NodeName]);
		}

		public function RemoveNode($NodeName)
		{
			if ((!is_string($NodeName) || strlen($NodeName) < 1) && !is_integer($NodeName)) {
				return $this;
			}

			if (isset($this->Nodes[$NodeName])) {
				unset($this->Nodes[$NodeName]);
			}

			return $this;
		}

		public function AddConnection($OutNodeName, $OutPortName, $InNodeName, $InPortName)
		{
			if (!$this->HasNode($OutNodeName) || !$this->HasNode($InNodeName)) {
				return $this;
			}

			if (!isset($this->InConnections[$InNodeName]) || !is_array($this->InConnections[$InNodeName])) {
				$this->InConnections[$InNodeName] = array();
			}

			if (!isset($this->OutConnections[$OutNodeName]) || !is_array($this->OutConnections[$OutNodeName])) {
				$this->OutConnections[$OutNodeName] = array();
			}

			if (!isset($this->InConnections[$InNodeName][$InPortName])) {
				$this->InConnections[$InNodeName][$InPortName] = array();
			}

			if (!isset($this->OutConnections[$OutNodeName][$OutPortName])) {
				$this->OutConnections[$OutNodeName][$OutPortName] = array();
			}

			$this->InConnections[$InNodeName][$InPortName][] = array(
				'OutNode' => $OutNodeName,
				'OutPort' => $OutPortName,
				'InNode'  => $InNodeName,
				'InPort'  => $InPortName
			);

			$this->OutConnections[$OutNodeName][$OutPortName][] = array(
				'OutNode' => $OutNodeName,
				'OutPort' => $OutPortName,
				'InNode'  => $InNodeName,
				'InPort'  => $InPortName
			);

			return $this;
		}

		public function RemoveConnection($OutNodeName, $OutPortName, $InNodeName, $InPortName)
		{
			if (isset($this->OutConnections[$OutNodeName]) && isset($this->OutConnections[$OutNodeName][$OutPortName])) {
				unset($this->OutConnections[$OutNodeName][$OutPortName]);
			}

			if (isset($this->InConnections[$InNodeName]) && isset($this->InConnections[$InNodeName][$InPortName])) {
				unset($this->InConnections[$InNodeName][$InPortName]);
			}

			return $this;
		}

		/**
		 * @return ComponentInterface|null
		 */
		protected function &GetFirstNode()
		{
			$Node = null;
			if (isset($this->Nodes[$this->CurrentNode])) {
				$Node = $this->Nodes[$this->CurrentNode];
			}

			return $Node;
		}

		/**
		 * @param ComponentInterface $CurrentNode
		 *
		 * @return ComponentInterface|null
		 */
		public function &GetNextNode(ComponentInterface $CurrentNode)
		{
			// Check the input connections of the current node to
			if (isset($this->OutConnections[$CurrentNode->GetName()])) {
				$Connections = current($this->OutConnections[$CurrentNode->GetName()]);

				foreach (array_values($Connections) as $Connection) {
					if (isset($Connection['InNode']) && $this->Nodes[$Connection['InNode']]) {
						if (!$this->Nodes[$Connection['InNode']]->IsExecuted() && !$this->Nodes[$Connection['InNode']]->IsRunning()) {
							return $this->Nodes[$Connection['InNode']];
						}
					}
				}
			}

			$Null = null;

			return $Null;
		}

		public function TransferConnections(ComponentInterface &$Node)
		{
			if (isset($this->InConnections[$Node->GetName()])) {
				foreach (array_values($this->InConnections[$Node->GetName()]) as $Connections) {
					foreach (array_values($Connections) as $Connection) {
						if (!$this->Nodes[$Connection['OutNode']]->IsExecuted()) {
							if ($this->Nodes[$Connection['OutNode']]->IsRunning()) {
								break;
							}

							$this->Execute($this->Nodes[$Connection['OutNode']]);
						}

						$Output = $this->Nodes[$Connection['OutNode']]->GetOutput($Connection['OutPort']);
						$Node->SetInput($Connection['InPort'], $Output);
					}
				}
			}

			return $Node;
		}

		public function Execute(ComponentInterface &$Node = null)
		{
			if ($Node === null) {
				$Node = $this->GetFirstNode();
			}

			if ($Node !== null) {
				if (!$Node->IsRunning()) {

					if (!$Node->IsExecuted()) {

						$Node->IsRunning(true);

						$Node = $this->TransferConnections($Node);

						$Node->Execute();

						$Node->IsRunning(false);

						$Node->IsExecuted(true);
					}
				}

				if (($NextNode = $this->GetNextNode($Node)) !== null) {
					if (!$NextNode->IsRunning()) {
						$this->Execute($NextNode);
					}
				}

				if (!$Node->IsStateful()) {
					$Node->ResetComponent();
				}
			}

			return true;
		}
	}

?>