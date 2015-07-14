<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemCollectionInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormattableItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormatterInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaPropertyInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemAllowerInterface;
use Illuminate\Support\Collection;


class ItemCollection extends collection implements ItemCollectionInterface, FormattableItemInterface, ItemInterface{


	use \RicAnthonyLee\Itemizer\Traits\ItemTrait;
	use \RicAnthonyLee\Itemizer\Traits\FormattableItemTrait;


	protected $allower, $name, $alias, $value;


	/**
	* set ItemCollection with a new array of Items
	**/

	public function setValue( $value )
	{

		unset( $this->items );


		if( !is_array( $value ) ) 
			$value = (array) $value;


		foreach( $value as $v )
		{
			
			$this->addItem( $v->getAlias(), $v );

		}

		return $this;

	}

	/**
	* @return array of Items
	**/

	public function getValue()
	{

		return $this->all();

	}


	/**
	* add an item
	**/

	public function addItem( ItemInterface $item )
	{

		$allower = $this->getAllower();

		if( $allower ) $allower->isAllowedOrFail( $item );

		$this->offsetSet( $item->getAlias(), $item );

	}

	/**
	* get an item by alias or name
	**/

	public function getItem( $name )
	{

		return $this->offsetGet( $name );

	}

	/**
	* remove an item
	**/

	public function removeItem( $name )
	{

		$this->forget( $name );

	}

	/**
	* check if item exists
	**/

	public function hasItem( $name )
	{

		return $this->contains( $name );

	}



	/**
	* set Item Allower Service
	**/

	public function setAllower( ItemAllowerInterface $allower )
	{

		$this->allower = $allower;

	}

	/**
	* get Item Allower Service
	**/

	public function getAllower()
	{

		return $this->allower;

	}

}