<?php namespace RicAnthonyLee\Itemizer\Interfaces;


use RicAnthonyLee\Itemizer\Interfaces\MetaInterface;


interface MetaPropertyInterface{


	/**
	* @return RicAnthonyLee\Itemizer\Interfaces\MetaInterface
	**/


	public function getMeta();

	/**
	* set the Meta object
	**/

	public function setMeta( MetaInterface $meta );


}