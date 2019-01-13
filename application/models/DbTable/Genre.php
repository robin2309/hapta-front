<?php

class Application_Model_DbTable_Genre extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_genre';
    protected $_primary = 'idGenre';    

    public function getGenre($id){
	    $row = $this->fetchRow('idGenre = ' . (int)$id);
	    if(!$row){
		    throw new Exception("Genre non trouvé : " . $id);
	    }
	    return $row->toArray();
    }
    
}

