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

		$col = new ItemCollection();
		$it  = new ItemFactory();
		$col->setName( "test" );
		$col->setItemFactory( $it );

		$col->addItem( "foo", "bar", "foo" );

		$col->foo2 = $it->make( 'foo2', 'bar', 'Foo2' );

		$this->assertEquals( $col->foo->value, $col['foo2']['value'] );


		return $col;

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

	/**
	* @depends testInit
	**/

	public function testItemCallbacks( $items )
	{

		$items->add( new Item("example") );

		$example = $items->get( "example" );

		$this->assertEquals( $example instanceof Item, true );

		$items->remove( "example" );

	}

	/**
	* @depends testInit
	**/

	public function testItemCreationViaOffsetSet( $col )
	{


		$col['foo'] = 'foo';
		
		$this->assertEquals( $col['foo']->getValue(), 'foo' );
		$this->assertEquals( (string) $col['foo'], 'foo' );

		return $col;

	}

	/**
	* @depends testItemCreationViaOffsetSet
	**/

	public function testItemCreationViaAddItem( $col )
	{

		$col->addItem( "key", "value", "alias" );

		$this->assertEquals( "value", (string) $col['alias'] );

	}

}
