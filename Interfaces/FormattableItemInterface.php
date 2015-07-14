<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface FormattableItemInterface{

	/**
	* set the service responsible for formatting data
	**/

	public function setFormatter( FormatterInterface $formatter );

	/**
	* get the formatting service
	**/

	public function getFormatter();


	/**
	* @return the Item in formatted state
	**/

	public function format();

}