<?php namespace RicAnthonyLee\Itemizer\Test;


use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormattableItemInterface;
use RicAnthonyLee\Itemizer\Interfaces\FormatterInterface;
use RicAnthonyLee\Itemizer\Interfaces\ItemCollectionInterface;

/**
* Simple test to convert all into json manually
**/


class JsonFormatter implements FormatterInterface{


	public function format( ItemInterface $item )
	{

		return $this->jsonEncode( $item );

	}


	/**
	* loops through the collection and return formatted results according to
	* the needs of the script
	* @return mixed formatted data
	**/


	protected function jsonEncode( $collection )
	{

		if( !$collection instanceof \Traversable )
			$collection = (array) $collection;


		$formattedItem = "{\"" .$collection->getName() ."\":";


		foreach( $collection as $key => $item )
		{

			//skip to the next item if item isn't formattable

			if( ! $item instanceof FormattableItemInterface ) continue;

			//set the formatter to Json formatter is it's not already

			if( !$item->getFormatter() instanceof JsonFormatter ) $item->setFormatter( $this );


			if( $item instanceof ItemCollectionInterface )
			{

				$formattedItem .= $item->format().",";

			}
			else 
			{

				$value          =  $this->formatValue( $item->getValue() );

				$formattedItem .= "{\"".$item->getName()."\":" .$value ."},";

			}

		}

		return rtrim($formattedItem, ",") ."}";

	}

	protected function formatValue( $value )
	{

		if( is_array($value) || $value instanceof \JsonSerializable || is_scalar( $value ) )
		{

			$value = json_encode($value);

		}
		else
		{

			throw \Exception( "cannot json serialize " .gettype( $value ) );

		}

		return $value;

	}


}