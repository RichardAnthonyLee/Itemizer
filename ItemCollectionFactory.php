<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\ItemCollection;
use RicAnthonyLee\Itemizer\Interfaces\ItemCollectionFactoryInterface;


class ItemCollectionFactory implements ItemCollectionFactoryInterface{


	/**
	* creates a new instance of the ItemCollection
	* @return RicAnthonyLee\Itemizer\ItemCollection
	**/

	public function make( $name, $value = false, $alias = false )
	{

		$collection = new ItemCollection;

		$collection->setName( $name );

		if( $value )
			$collection->setItem( $value );

		if( $alias )
			$collection->setAlias( $alias );

		return $collection;

	}


}