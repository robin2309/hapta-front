<?php

class Application_Model_DbTable_PriceEvent extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_event_price';
    protected $_primary = array('idEvent','idType');
    
    public function getPricesForEvent($idEvent){
    	$db = $this->getAdapter();
    	$sql = "SELECT hep.idEvent as idEvent, htp.nameType as name, hep.price as price, hep.link as link FROM hapta_type_price htp join hapta_event_price hep ON htp.id = hep.idType WHERE idEvent= :idEvent";
    	return $db->fetchAll($sql, array(':idEvent'=>$idEvent));
    }
    
    public function getPrices($idEvent){
	    $select = $this->select()
	    			   ->from($this->_name)
	    			   ->where('idEvent = ?', $idEvent);
        return $this->fetchAll($select);
    }            

}

