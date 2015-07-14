<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormattableItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormatterInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaPropertyInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemAllowerInterface;


class Item implements ItemInterface, FormattableItemInterface, MetaPropertyInterface{


	use \RicAnthonyLee\Itemizer\Traits\ItemTrait;
	use \RicAnthonyLee\Itemizer\Traits\FormattableItemTrait;


	protected $name, $alias, $formatter, $meta, $value;


	public function __construct( $name, $alias = false, $value = null )
	{

		$this->setName( $name );

		if( $alias ) $this->setAlias( $alias );
		if( isset($value) ) $this->setValue( $value );

	}


	/**
	* return formatted item if formatter returns string
	* else return all values as json
	**/

	public function __toString()
	{

		if( $formatter = $this->getFormatter() )
		{

			if( is_string( $format = $this->format() ) )
				return $format;

		}
		else if( is_string( $this->getValue() ) )
		{

			return $this->getValue();

		}

		throw \Exception("Cannot convert RicAnthonyLee\Itemizer\Item to String");

	}


	/**
	* @return RicAnthonyLee\Itemizer\Interfaces\MetaInterface
	**/


	public function getMeta()
	{

		return $this->meta;

	}

	/**
	* set the Meta object
	**/

	public function setMeta( MetaInterface $meta )
	{

		$this->meta = $meta;
		return $this;

	}

}