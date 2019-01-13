<?php

class Application_Model_DbTable_Spot extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_club';
    
    public function getSpot($id){
	    $row = $this->fetchRow('id = ' . (int)$id);
	    if(!$row){
		    throw new Exception("Spot non trouvé : " . $id);
	    }
	    return $row->toArray();
    }    

}

