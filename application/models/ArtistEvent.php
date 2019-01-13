<?php

class Application_Model_ArtistEvent
{

	protected $_dataTable;
	
	public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_ArtistEvent();
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
    
    public function getArtistsEvent($id){
	    return $this->_dataTable->getArtistsName($id);
    }

}

