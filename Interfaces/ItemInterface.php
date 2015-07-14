<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface ItemInterface{


	/**
	* Assign a name to the Item
	**/

	public function setName( $name );

	/**
	* Get the assigned name of the Item
	**/

	public function getName();

	/**
	* Assign an alias to the item
	**/

	public function setAlias( $alias );

	/**
	* Get the assigned alias
	**/

	public function getAlias();

	/**
	* Assign a value to the Item
	**/

	public function setValue( $value );

	/**
	* Get the value of the item
	**/

	public function getValue(); 


}