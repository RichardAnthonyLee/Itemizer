<?php namespace RicAnthonyLee\Itemizer;


use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormattableItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormatterInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaPropertyInterface;
use RicAnthonyLee\Itemizer\Interfaces\MetaInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemAllowerInterface;
use ArrayAccess;


class Item implements ItemInterface, FormattableItemInterface, MetaPropertyInterface, ArrayAccess{


	use \RicAnthonyLee\Itemizer\Traits\ItemTrait;
	use \RicAnthonyLee\Itemizer\Traits\FormattableItemTrait;
	use \RicAnthonyLee\Itemizer\Traits\AccessorTrait;


	protected $name;

	protected $alias;

	protected $formatter; 

	protected $meta;

	protected $value; 


	protected $accessibleProperties = [ 'name', 'value', 'alias' ];


	public function __construct( $name, $alias = false, $value = null )
	{

		$this->setName( $name );

		if( $alias ) $this->setAlias( $alias );
		if( isset($value) ) $this->setValue( $value );

	}


	/**
	* return formatted item if formatter returns string
	**/

	public function __toString()
	{

		if( $formatter = $this->getFormatter() )
		{

			if( is_string( $format = $this->format() ) )
				return $format;

		}
		
		return (string) $this->getValue();

	}


	public function offsetGet( $var )
	{

		if( !$this->isAccessibleProperty( $var ) )
		{
			throw new \InvalidArgumentException( "Illegal Offset ".$var." for ".get_class() );
		}

		return $this->__get( $var );

	}

	public function offsetSet( $var, $value )
	{

		if( !$this->isAccessibleProperty( $var ) )
		{
			throw new \InvalidArgumentException( "Illegal Offset ".$var." for ".get_class() );
		}

		return $this->__set( $var, $value );

	}	

	public function offsetExists( $var )
	{
		return !!$this->__get( $var );
	}

	public function offsetUnset( $var )
	{

		if( $var === 'value' )
		{
			$this->setValue( null );
		}

		return null;

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