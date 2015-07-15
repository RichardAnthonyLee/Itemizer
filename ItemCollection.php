<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemFactoryInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemCollectionFactoryInterface;
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
	use \RicAnthonyLee\Itemizer\Traits\CallbackMapperTrait;


	protected $allower, $name, $alias, $value, $factory, $itemFactory;


    public function __construct($items = [])
    {

       parent::__construct($items);
       $this->__setCallbacks();
    
    }


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

		$this->items[ $item->getAlias() ] = $item;

	}

	/**
	* get an item by alias or name
	**/

	public function getItem( $name )
	{

		return $this->items[ $name ];

	}

	/**
	* set item array style
	**/


	public function offsetSet($key, $v)
	{

		return $this->setItem( $key, $v );

	}

	/**
	* get an item by alias/name
	**/

	public function offsetGet( $key )
	{

		return $this->getItem( $key );
		
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

	/**
	* set the factory object for creating item collections
	**/

	public function setFactory( ItemCollectionFactoryInterface $factory )
	{

		$this->factory = $factory;
		return $this;

	}

	/**
	* @return the factory object for creating item collection
	**/

	public function getFactory()
	{

		return $this->factory;

	}

	/**
	* set the factory object for creating items
	**/

	public function setItemFactory( ItemFactoryInterface $factory )
	{

		$this->itemFactory = $factory;
		return $this;

	}

	/**
	* @return the factory object for creating items
	**/

	public function getItemFactory()
	{

		return $this->itemFactory;

	}	

	/**
	* set the configuration callback/map for the __call magic method
	* @return void
	**/

	protected function __setCallbacks()
	{

		$this->setCallbackMap([  
			"add"     => "addItem",
			"remove"  => "removeItem",
			"set"     => "addItem",
			"has"     => "hasItem",
			"value"   => "getValue",
			"factory" => "getFactory",
			"item"    => "getItemFactory"
		]);

	}
}