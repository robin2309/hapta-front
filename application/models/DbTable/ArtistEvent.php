<?php

class Application_Model_DbTable_ArtistEvent extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_event_artist';
    protected $_primary = array('idArtist','idEvent');

    public function getArtists($id){
	    $select = $this->select()
	    			   ->from($this->_name, array('idArtist'))
	    			   ->where('idEvent = ?', $id);
        $rows = $this->fetchAll($select);
        $idArtists = array();
        foreach($rows as $row){
        	$idArtists[]=$row['idArtist'];
        }
        return $idArtists;
    }
    
    public function getArtistsName($idEvent){
	    $db = $this->getAdapter();
	    $sql = "SELECT CONCAT(a.name, ' (', a.label,' [', a.country,'])') as name FROM hapta_artist a, hapta_event_artist ea WHERE ea.idArtist = a.idArtist and ea.idEvent = :idEvent";
	    $rows = $db->fetchAll($sql, array(':idEvent'=>$idEvent));
	    $artists = array();
        foreach($rows as $row){
        	$artists[]=$row['name'];
	        //array_push($idArtists, $row);
        }
        return implode(', ',$artists);
    }

}

