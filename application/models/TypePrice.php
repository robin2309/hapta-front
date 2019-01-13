<?php

class Application_Model_TypePrice
{
	protected $_id;
	protected $_type;
	
	public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    //GETTERS
    public function getId(){
	    return $this->_id;
    }
    
    public function getName(){
	    return $this->_name;
    }

    //SETTERS
    public function setId($id){
	    $this->_id = $id;
	    return $this;
    }
    
    public function setName($name){
	    $this->_name = $name;
	    return $this;
    }
}

