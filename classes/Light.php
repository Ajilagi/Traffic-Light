<?php

class Light{
	protected $color;
	protected $power;

	protected function turnOn($value='')
	{
		$this->power = true;
	}

	protected function turnOff($value='')
	{
		$this->power = false;
	}
}

?>