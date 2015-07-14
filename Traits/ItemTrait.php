<?php namespace RicAnthonyLee\Itemizer\Traits;


trait ItemTrait{



	/**
	* Assign a name to the Item
	**/

	public function setName( $name )
	{

		$this->name = (string) $name;
		return $this;

	}

	/**
	* Get the assigned name of the Item
	**/

	public function getName()
	{

		return $this->name;

	}

	/**
	* Assign an alias to the item
	**/

	public function setAlias( $alias )
	{

		$this->alias = (string) $alias;
		return $this;

	}

	/**
	* Get the assigned alias
	**/

	public function getAlias()
	{

		return $this->alias ?: $this->name;

	}

	/**
	* Assign a value to the Item
	**/

	public function setValue( $value )
	{

		$this->value = $value;
		return $this;

	}

	/**
	* Get the value
	**/

	public function getValue()
	{

		return $this->value;

	}

}