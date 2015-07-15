<?php

use RicAnthonyLee\Itemizer\Item;
use RicAnthonyLee\Itemizer\Interfaces\ItemInterface;
use RicAnthonyLee\Itemizer\ItemCollection;
use RicAnthonyLee\Itemizer\ItemCollectionFactory;
use RicAnthonyLee\Itemizer\ItemFactory;
use RicAnthonyLee\Itemizer\Test\JsonFormatter;


require dirname(dirname(__FILE__)) .'/vendor/autoload.php';


class ItemizerTest extends PHPUnit_Framework_TestCase{


	public function testInit()
	{

		$criteriaBuilder = new ItemCollection();
		$dimensions      = new ItemCollection();

		$criteriaBuilder->setName( "args" );
		$dimensions->setName( "dimensions" );

		$ipAddress       = new Item( "dimension1", "ipAddress", "127.0.0.1" );


		$dimensions->addItem( $ipAddress );
		$criteriaBuilder->addItem( $dimensions );

		$ip = $criteriaBuilder->getItem( "dimensions" )->getItem( "ipAddress" )->getValue();


		$this->assertEquals( "127.0.0.1", $ip );


		$ipFromArray = $criteriaBuilder["dimensions"]["ipAddress"]->getValue();


		$this->assertEquals( $ip, $ipFromArray );


		$dimensionName = $criteriaBuilder["dimensions"]["ipAddress"]->getName();


		$this->assertEquals("dimension1", $dimensionName);


		return $criteriaBuilder;

	}

	/**
	* @depends testInit
	**/


	public function testItemFormatting( $col )
	{

		$col->setFormatter( new JsonFormatter );

		$decoded = json_decode( $col->format() );

		$this->assertEquals( is_object( $decoded ), true ); 


	}

	/**
	* @depends testInit
	**/

	public function testItemFactories( $col )
	{

		$col->setFactory( new ItemCollectionFactory )
			->setItemFactory( new ItemFactory );

		$made     = $col->getFactory()->make( "example" );
		$madeItem = $col->getItemFactory()->make( "example2", 1, "test" );


		$this->assertEquals( $made instanceof ItemCollection, true );
		$this->assertEquals( $madeItem->getName(), "example2" );

	}



}
