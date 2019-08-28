<?php

/**
 * 
 */
trait JsonSerializer {
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class Trafficlight extends Light implements \JsonSerializable
{
	use Crossroad ;
	use JsonSerializer;
	private $status;
	function __construct($newStatus)
	{
		$this->color = ["red", "yellow", "green"];
		if($newStatus == "on"){
			$this->status = "on";
		}else{
			$this->status = "off";
			$this->power = [false, false, false];
		}
	}
	public function turnRed()
	{
		$this->power = [true, false, false];
	}
	public function turnYellow()
	{
		$this->power = [false, true, false];
	}
	public function turnGreen()
	{
		$this->power = [false, false, true];
	}
	public function getPower()
	{
		return $this->power;
	}
	public function getStatus()
	{
		return $this->status;
	}
}

?>