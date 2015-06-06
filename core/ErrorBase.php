<?php

	namespace Flow\Core;

	use Flow\Core\Interfaces\ErrorInterface;

	class ErrorBase implements ErrorInterface
	{
		protected $_ErrorMessages = array();

		protected function AddError($Message)
		{
			if (!is_string($Message) || strlen($Message) < 1) {
				return false;
			}

			$this->_ErrorMessages[] = $Message;

			return true;
		}

		public function HasError()
		{
			return !empty($this->_ErrorMessages);
		}

		public function GetErrors()
		{
			return $this->_ErrorMessages;
		}
	}