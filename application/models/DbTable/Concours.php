<?php

class Application_Model_DbTable_Concours extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_concours';

    public function getCurrent(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.dateDeb, co.dateFin, co.nbPlaces, co.nbGagnants, co.publie, co.valide, co.idPostConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE co.valide = 1 and co.publie = 1 and (co.dateDeb<now() and co.dateFin>=now()) and passe=0 ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql);
    }
    
    public function countCurrent(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT count(*) as nbConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE co.valide = 1 and co.publie = 1 and (co.dateDeb<now() and co.dateFin>=now()) and passe=0 ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql)[0]['nbConcours'];
    }
    
    public function getUpcoming(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.dateDeb, co.dateFin, co.nbPlaces, co.nbGagnants, co.publie, co.valide FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE co.valide = 1 and co.publie = 0 and co.dateFin>=now() ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql);
    }
    
    public function countUpcoming(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT count(*) as nbConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE co.valide = 1 and co.publie = 0 and co.dateFin>=now() ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql)[0]['nbConcours'];
    }
    
    public function countAll(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT count(*) as nbConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE e.publie = 1 AND co.valide = 1";
	    return $db->fetchAll($sql)[0]['nbConcours'];
    }
    
    public function getConcoursFromEvent($idEvent){
	    $db = $this->getAdapter();
	    $sql = "select * from hapta_concours where idEvent=:idEvent";
	    return reset($db->fetchAll($sql, array(':idEvent'=>$idEvent))); //retrieve first element of array
    }
    
}

