<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface ItemAllowerInterface{
	

	/**
	* check if the item is allowed
	**/

	public function isAllowed( ItemInterface $item );
	

	/**
	* set the names of the allowed items
	**/

	public function setAllowed( array $items );


	/**
	* @return the names of the allowed items
	**/

	public function getAllowed();

	/**
	* create an exception when Item is not allowed
	**/

	public function createItemNotAllowedException( ItemInterface $item = null );

	/**
	* fails if the item is not allowed
	**/

	public function isAllowedOrFail( ItemInterface $item );
}