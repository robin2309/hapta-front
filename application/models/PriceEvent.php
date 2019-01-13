<?php

class Application_Model_PriceEvent
{
	protected $_idEvent;
	protected $_type;
	protected $_price;
	protected $_link;
	protected $_dataTable;

	public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_PriceEvent();
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
    public function getIdEvent(){
	    return $this->_idEvent;
    }
    
    public function getType(){
	    return $this->_type;
    }
    
    public function getPrice(){
	    return $this->_price;
    }
    
    public function getLink(){
	    return $this->_link;
    }
    
    //SETTERS
    public function setIdEvent($idEvent){
	    $this->_id = $idEvent;
	    return $this;
    }
    
    public function setType($type){
	    $this->_type = $type;
	    return $this;
    }
    
    public function setPrice($price){
	    $this->_price = $price;
	    return $this;
    }
    
    public function setLink($link){
	    $this->_link = $link;
	    return $this;
    }
    
    public function getPricesEvent($idEvent){
	    $prices = $this->_dataTable->getPricesForEvent($idEvent);
	    $pricesArray = array();
	    foreach($prices as $price){
	    	$priceToAdd = new Application_Model_PriceEvent($price);
	    	$type = new Application_Model_TypePrice(array('name' => $price['name']));
	    	$priceToAdd->setType($type);
	    	$pricesArray[]=$priceToAdd;
	    }
	    return $pricesArray;
    }
    
    public function getPricesEventArray($idEvent){
	    return $this->_dataTable->getPricesForEvent($idEvent);
    }

}

