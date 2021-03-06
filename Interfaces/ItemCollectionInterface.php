<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface ItemCollectionInterface extends \IteratorAggregate{

	/**
	* add an item
	**/

	public function addItem( $key, $value, $alias );

	/**
	* get an item
	**/

	public function getItem( $name );

	/**
	* remove an item
	**/

	public function removeItem( $name );

	/**
	* check if the item exists
	**/

	public function hasItem( $name );

	/**
	* set Item Allower Service
	**/

	public function setAllower( ItemAllowerInterface $allower );

	/**
	* get Item Allower Service
	**/

	public function getAllower();


	/**
	* set the factory object for creating item Collections
	**/

	public function setFactory( ItemCollectionFactoryInterface $factory );

	/**
	* get the factory object for creating item collections
	**/

	public function getFactory();	


	/**
	* set the factory object for creating items
	**/

	public function setItemFactory( ItemFactoryInterface $factory );


	/**
	* get the factory object for creating items
	**/

	public function getItemFactory();	



}