<?php

class JSONResult extends Result
{
	/* (non-PHPdoc)
	 * @see Result::getResult()
	 */
	public function getResult()
	{
		return json_encode($this->result);
	}


	
}
