<?php

class Application_Model_DbTable_GenreEvent extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_event_genre';
    protected $_primary = array('idEvent','idGenre');
    
    public function getGenres($id){
	    $select = $this->select()
	    			   ->from($this->_name, array('idGenre'))
	    			   ->where('idEvent = ?', $id);
        $rows = $this->fetchAll($select);
        $idGenres = array();
        foreach($rows as $row){
        	$idGenres[]=$row['idGenre'];
        }
        return $idGenres;
    }
    
    public function getGenresName($idEvent){
	    $db = $this->getAdapter();
	    $sql = "SELECT g.nameGenre FROM hapta_genre g, hapta_event_genre eg WHERE eg.idGenre = g.idGenre and eg.idEvent = :idEvent";
	    $rows = $db->fetchAll($sql, array(':idEvent'=>$idEvent));
	    $genres = array();
        foreach($rows as $row){
        	$genres[]=$row['nameGenre'];
        }
        return $genres;
    }
    
}

