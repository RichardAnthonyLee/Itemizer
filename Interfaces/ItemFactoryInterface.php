<?php namespace RicAnthonyLee\Itemizer\Interfaces;


interface ItemFactoryInterface{

	/**
	* creates a new instance of the ItemInterface
	**/


	public function make( $name, $value = false, $alias = false );


}