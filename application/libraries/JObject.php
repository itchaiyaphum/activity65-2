<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class JObject
{
    /**
     * An array of errors
     *
     * @var		array of error messages or JExceptions objects
     * @access	protected
     */
    var		$_errors		= array();
    
	/**
	 * Class constructor, overridden in descendant classes.
	 *
	 * @access	protected
	 */
	function __construct() {}


	/**
	 * Returns a property of the object or the default value if the property is not set.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $default The default value
	 * @return	mixed The value of the property
	 * @see		getProperties()
 	 */
	function get($property, $default=null)
	{
		if(isset($this->$property)) {
			return $this->$property;
		}
		return $default;
	}

	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
	 * @see		get()
 	 */
	function getProperties( $public = true )
	{
		$vars  = get_object_vars($this);

        if($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
			}
		}

        return $vars;
	}

	/**
	 * Modifies a property of the object, creating it if it does not already exist.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $value The value of the property to set
	 * @return	mixed Previous value of the property
	 * @see		setProperties()
	 */
	function set( $property, $value = null )
	{
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	/**
	* Set the object properties based on a named array/hash
	*
	* @access	protected
	* @param	$array  mixed Either and associative array or another object
	* @return	boolean
	* @see		set()
	*/
	function setProperties( $properties )
	{
		$properties = (array) $properties; //cast to an array

		if (is_array($properties))
		{
			foreach ($properties as $k => $v) {
				$this->$k = $v;
			}

			return true;
		}

		return false;
	}

	/**
	 * Object-to-string conversion.
	 * Each class can override it as necessary.
	 *
	 * @access	public
	 * @return	string This name of this class
 	 */
	function toString()
	{
		return get_class($this);
	}
	
	/**
	 * Get the most recent error message
	 *
	 * @param	integer	$i Option error index
	 * @param	boolean	$toString Indicates if JError objects should return their error message
	 * @return	string	Error message
	 * @access	public
	 */
	function getError($i = null, $toString = true )
	{
	    // Find the error
	    if ( $i === null) {
	        // Default, return the last message
	        $error = end($this->_errors);
	    }
	    else
	        if ( ! array_key_exists($i, $this->_errors) ) {
	            // If $i has been specified but does not exist, return false
	            return false;
	        }
	    else {
	        $error	= $this->_errors[$i];
	    }
	
	    // Check if only the string is requested
	    if ( JError::isError($error) && $toString ) {
	        return $error->toString();
	    }
	
	    return $error;
	}
	
	/**
	 * Return all errors, if any
	 *
	 * @access	public
	 * @return	array	Array of error messages or JErrors
	 */
	function getErrors()
	{
	    return $this->_errors;
	}
	
	/**
	 * Add an error message
	 *
	 * @param	string $error Error message
	 * @access	public
	 */
	function setError($error)
	{
	    array_push($this->_errors, $error);
	}

}
