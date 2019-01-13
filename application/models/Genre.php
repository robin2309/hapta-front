<?php

class Application_Model_Genre
{
	protected $_id;
	protected $_name;
	protected $_valide;
	protected $_changeRequest;
	
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
    
    public function getValide(){
	    return $this->_valide;
    }
    
    public function getChangeRequest(){
	    return $this->_changeRequest;
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
    
    public function setValide($valide){
	    $this->_valide = $valide;
	    return $this;
    }
    
    public function setChangeRequest($changeRequest){
	    $this->_changeRequest = $changeRequest;
	    return $this;
    }

}

