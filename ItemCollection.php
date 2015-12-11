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


	protected $allower, $name, $alias, $value, $factory, $itemFactory, $formatter, $items = [];


	/**
	* override default constructor so that each item
	* in the collection is set through ::addItem method
	**/


    public function __construct($items = [])
    {

    	if( !empty( $items ) )
    		$this->setValue( $items );

       $this->__setCallbacks();
    
    }

    /**
    * @return mixed value of collection name or value, or an item from the collection 
    **/

    public function __get( $var )
    {

    	return $this->offsetGet( $var );

    }


    /**
    * sets value of collection name or value, or adds an item from the collection 
    * @return void 
    **/    

    public function __set( $var, $value )
    {

    	return $this->offsetSet( $var, $value );

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

			//allow user to have passed either an item of an array 
			//of item properties

			call_user_func_array( 
				[ $this, 'addItem' ], 
				is_array( $v ) ? $v : (array) $v 
			);


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

	public function addItem( $key, $value = null, $alias = null )
	{

		$args = func_get_args();


		switch ( count( $args ) ) 
		{
			case 1:
				
				if( !($args[0] instanceof ItemInterface) )
				{

					throw new \InvalidArgumentException( 
						"Argument 1 for addItem method must be instance of RicAnthonyLee\Itemizer\Interfaces\ItemInterface" 
					);

				}

				//pass item as-is if already created

				$item = $args[0];

			break;
			
			default:
			
				//create an item on the fly if parameters are passed to collection

				$item = $this->getItemFactory()->make( $key, $value, $alias );

			
			break;
		}


		$allower = $this->getAllower();

		if( $allower ) $allower->isAllowedOrFail( $item );

		$this->items[ $item->getAlias() ] = $item; 

		return $this;

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

		if( is_null( $key ) )
			throw new \InvalidArgumentException( "Item in ".get_class()."::offsetSet must be set with Associative key" );

		if( ($v instanceof ItemInterface ) )
		{

			//if value is an Item object, just set the alias as the given key
			$v->setAlias( $key );

		}
		else
		{

			//if key references name or value properties,
			//set them

			if( in_array( $key, ['name', 'value'] ) )
			{

				return $this->{'set'.ucfirst($key)}( $v );

			}

			//if value is not an Item object
			//and the key is not referencing the name/value properties
			//convert it to item
			$v = $this->getItemFactory()->make( $key, $v );

		}

		return $this->addItem( $v );

	}

	/**
	* get an item by alias/name
	**/

	public function offsetGet( $key )
	{
		//if key references name or value properties,
		//get them

		if( in_array( $key, ['name', 'value'] ) )
		{

			return $this->{'get'.ucfirst($key)}();

		}

		//else attempt to get an Item

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