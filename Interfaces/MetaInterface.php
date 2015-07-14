<?php namespace RicAnthonyLee\Itemizer\Interfaces;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\ItemCollectionInterface;


interface MetaInterface{

	/**
	* @return the value of the meta data 
	**/

	public function getMeta( $name );

	/**
	* set the value of the meta data
	**/

	public function setMeta( $name, ItemInterface $item );

	/**
	* check if meta value is set
	**/

	public function hasMeta( $name );

	/**
	* @return all meta data
	**/

	public function allMeta();


}