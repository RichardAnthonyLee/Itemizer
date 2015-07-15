<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemFactoryInterface;


class ItemFactory implements ItemFactoryInterface{


	/**
	* creates a new instance of the ItemInterface
	* @return RicAnthonyLee\Itemizer\Item
	**/

	public function make( $name, $value = false, $alias = false )
	{

		return new Item( $name, $alias, $value );

	}


}