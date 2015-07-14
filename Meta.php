<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemCollectionInterface;


class Meta extends ItemCollection, implements MetaInterface{



	/**
	* @return the value of the meta data 
	**/

	public function getMeta( $name )
	{

		return $this->getItem( $name );

	}

	/**
	* set the value of the meta data
	**/

	public function setMeta( $name, ItemInterface $item )
	{

		$this->setItem( $name, $item );

	}

	/**
	* check if meta value is set
	* @return bool true or false
	**/

	public function hasMeta( $name )
	{

		return $this->hasValue( $name );

	}

	/**
	* @return array of all meta data
	**/

	public function allMeta()
	{

		return $this->all();

	}


}