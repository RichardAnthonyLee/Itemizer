<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemAllowerInterface;


class ItemAllower implements ItemAllowerInterface{

	protected $allowed = null;

	/**
	* check if the item is allowed
	**/

	public function isAllowed( ItemInterface $item )
	{

		if( ( $allowed = $this->getAllowed() ) && !in_array( $item->getName(),  $allowed ) )
		{	
			return false;
		}

		return true;

	}
	

	/**
	* set the names of the allowed items
	**/

	public function setAllowed( array $items )
	{

		$this->allowed = $items;

	}


	/**
	* @return the names of the allowed items
	**/

	public function getAllowed()
	{

		return $this->allowed;

	}

	/**
	* create an exception when Item is not allowed
	**/

	public function createItemNotAllowedException( ItemInterface $item = null )
	{

		return new \Exception( "Item: " .$item->getName() ." is not allowed" );

	}

	/**
	* fails if the item is not allowed
	**/

	public function isAllowedOrFail( ItemInterface $item )
	{

		$allowed = $this->isAllowed( $item );

		if( $allowed )
			return $allowed;

		throw $this->createItemNotAllowedException( $item );
	}

}

