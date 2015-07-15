<?php namespace RicAnthonyLee\Itemizer\Traits;

use RicAnthonyLee\Itemizer\Exceptions\CallbackNotFoundException;


trait CallbackMapperTrait{


	protected $callbackMap = [];


	public function __call( $fn, $args )
	{

		try{


			return $this->resolveCallbackMethod( $fn, $args );


		} catch ( CallbackNotFoundException $e ) {


			throw new \BadMethodCallException( "Call to undefined method: ".__CLASS__."::".$fn );


		}

	}


	/** 
	* create a map of methods that __call should default to
	* @param array map of callbacks
	* @return void
	**/

	protected function setCallbackMap( array $map )
	{

		$this->callbackMap = $map;

	}

	/** 
	* merge map
	* @param array map of callbacks
	* @return void
	**/

	protected function mergeCallbackMap( array $map )
	{

		$this->callbackMap = array_merge( $this->getCallbackMap(), $map );

	}


	/**
	* @return array the callback map
	**/

	protected function getCallbackMap()
	{

		return $this->callbackMap;

	}


	/**
	* call the method
	* @throws RicAnthonyLee\Itemizer\Exceptions\CallbackNotFoundException if not found
	* @return the method return value 
	**/

	protected function resolveCallbackMethod( $fn, $args )
	{


		$map =  $this->getCallbackMap();


		if( !isset( $map[ $fn ] ) )
		{

			throw new CallbackNotFoundException( "No method assigned to resolve ".__CLASS__."::".$fn );
		
		}

		$method = $map[ $fn ];


		if( !method_exists( $this, $method ) )
		{

			throw new CallbackNotFoundException( "undefined method: ".$method." was assigned to resolve " .__CLASS__."::".$fn );

		}


		return call_user_func_array( [$this, $method] , $args );

	}


}