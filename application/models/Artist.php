<?php

class Application_Model_Artist
{
	protected $_id;
	protected $_name;
	protected $_label;
	protected $_country;
	protected $_valide;
	protected $_changeRequest;
	protected $_dataTable;
	protected $_city;

	
	public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_Artist();
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
    
    public function getLabel(){
	    return $this->_label;
    }
    
    public function getCountry(){
	    return $this->_country;
    }
    
    public function getValide(){
	    return $this->_valide;
    }
    
    public function getChangeRequest(){
	    return $this->_changeRequest;
    }
    
    public function getCity(){
	    return $this->_city;
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
    
    public function setLabel($label){
	    $this->_label = $label;
	    return $this;
    }
    
    public function setCountry($country){
	    $this->_country = $country;
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
    
    public function setCity($city){
	    $this->_city = $city;
	    return $this;
    }
    
    public function getArtistsFromEvent($idEvent){
	    $result = $this->_dataTable->getArtistsFromEvent($idEvent);
	    $artists = array();
	    foreach ($result as $row){
	    	$entry = new Application_Model_Artist($row);
	    	$artists[] = $entry;
	    }
	    return $artists;
    }
    
    public function getArtistsArrayFromEvent($idEvent){
	    return $this->_dataTable->getArtistsFromEvent($idEvent);
    }

}

