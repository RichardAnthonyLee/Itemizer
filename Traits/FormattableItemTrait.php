<?php namespace RicAnthonyLee\Itemizer\Traits;


use RicAnthonyLee\Itemizer\Interfaces\FormatterInterface;


trait FormattableItemTrait{

	/**
	* set the service responsible for formatting data
	**/

	public function setFormatter( FormatterInterface $formatter )
	{

		$this->formatter = $formatter;
		return $this;

	}

	/**
	* get the formatting service
	**/

	public function getFormatter()
	{

		return isset( $this->formatter ) ? $this->formatter : null;

	}


	/**
	* @return the Item in formatted state
	**/

	public function format()
	{

		return $this->formatter->format( $this );

	}

}