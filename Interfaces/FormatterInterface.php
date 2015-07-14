<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface FormatterInterface{

	/**
	* @return the Item in formatted state
	**/

	public function format( ItemInterface $item );


}