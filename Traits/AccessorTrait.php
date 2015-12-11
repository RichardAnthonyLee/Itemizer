<?php namespace RicAnthonyLee\Itemizer\Traits;


trait AccessorTrait{


	public function __get( $var )
	{

		$result = $this->attemptAccessorCall( 'get', $var );

		return $result->envoked ? $result->result : null;

	}


	public function __set( $var, $value )
	{

		$result = $this->attemptAccessorCall( 'set', $var, [ $value ] );

		return $result->envoked ? $result->result : null;

	}


	public function getAccessibleProperties()
	{
		return $this->accessibleProperties ?: [];
	}

	public function isAccessibleProperty( $var )
	{
		return in_array( $var, $this->getAccessibleProperties() );
	}

	public function attemptAccessorCall( $method, $name, array $params = array() )
	{

		$result = (object) [
			'envoked' => false,
			'result'  => null,
			'method'  => $method,
			'name'    => $name,
			'params'  => $params,
		];

		if( $this->isAccessibleProperty( $name ) )
		{

			$result->result  = $this->callAccessor( $method, $name, $params );
			$result->envoked = true; 

		}

		return $result;

	}

	public function callAccessor( $method, $name, array $params = array() )
	{

		return call_user_func_array([
			$this,
			$method.ucfirst($name)
		], $params );

	}


}