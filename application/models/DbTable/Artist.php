<?php

class Application_Model_DbTable_Artist extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_artist';
    protected $_primary = 'idArtist';

    public function getArtist($id){
	    $row = $this->fetchRow('idArtist = ' . (int)$id);
	    if(!$row){
		    throw new Exception("Artiste non trouvé : " . $id);
		}
	    return $row->toArray();
    }
    
    public function getArtistsFromEvent($idEvent){
	    $db = $this->getAdapter();
	    $sql = "SELECT ha.name, ha.label, ha.country FROM hapta_artist ha JOIN hapta_event_artist hea ON ha.idArtist = hea.idArtist AND hea.idEvent=:idEvent";
	    return $db->fetchAll($sql, array(':idEvent'=>$idEvent));
    }

}

