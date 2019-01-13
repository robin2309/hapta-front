<?php

class Application_Model_DbTable_Event extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_event';

    public function getArtistsEvent($idEvent){
	    $dbArtistEvent = new Application_Model_DbTable_ArtistEvent();
	    $artists = $dbArtistEvent->getArtistsName($idEvent);
	    return implode(', ', $artists);
    }
    
    public function getEventsStart(){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM (select distinct date from hapta_event where date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') and publie=1 order by date limit 3) as hd LEFT JOIN hapta_event e ON hd.date = e.date LEFT JOIN hapta_event_admin ad ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE e.publie = 1 ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql);
    }
    
    public function getEventsMore($dateLast){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM (select distinct date from hapta_event where date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') and date>:dateLast and publie=1 order by date limit 3) as hd LEFT JOIN hapta_event e ON hd.date = e.date LEFT JOIN hapta_event_admin ad ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE e.publie = 1 ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql, array(':dateLast'=>$dateLast));
    }
    
    public function getNbEventsByDate(){
	    $db = $this->getAdapter();
	    $sql = "SELECT count(id) as nbEvents, date FROM `hapta_event` WHERE publie = 1 AND date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') and publie=1 GROUP BY date ORDER BY date LIMIT 3";
	    return $db->fetchAll($sql);
    }
    
    public function getNbEventsByDateMore($dateLast){
	    $db = $this->getAdapter();
	    $sql = "SELECT count(id) as nbEvents, date FROM `hapta_event` WHERE publie = 1 AND date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') AND date>:dateLast AND publie=1 GROUP BY date ORDER BY date LIMIT 3";
	    return $db->fetchAll($sql, array(':dateLast'=>$dateLast));
    }
    
    public function getEvent($id){
	    $rowEvent = $this->fetchRow('id = ' . (int)$id);
	    if(!$rowEvent){
		    throw new Exception("Evenement non trouvé : " . $id);
	    }
	    $event = $rowEvent->toArray();
	    
        /*$event['idArtist'] = $this->getArtistEvent($id);
        $event['idGenre'] = $this->getGenreEvent($id);
        $event['idAdmins'] = $this->getAdminEvent($id);
        $event['idPrices'] = $this->getPriceEvent($id);*/
	    return $event;
    }
    
    /*private function getArtistEvent($idEvent){
	    $dbArtistEvent = new Application_Model_DbTable_ArtistEvent();
	    return $dbArtistEvent->getArtists($idEvent);
    }*/
    
    private function getGenreEvent($idEvent){
	    $dbGenreEvent = new Application_Model_DbTable_GenreEvent();
	    return $dbGenreEvent->getGenres($idEvent);
    }
    
    private function getAdminEvent($idEvent){
	    $dbAdminEvent = new Application_Model_DbTable_AdminEvent();
	    return $dbAdminEvent->getAdmins($idEvent);
    }
    
    /*private function getPriceEvent($idEvent){
    	$dbPriceEvent = new Application_Model_DbTable_PriceEvent();
    	return $dbPriceEvent->getPrices($idEvent);
    }*/
    
    public function searchEvents($query){
	    $db = $this->getAdapter();
	    $query = '%'.$query.'%';
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent where e.date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') AND e.publie AND (e.name LIKE :query OR cl.name LIKE :query) ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql, array(':query'=>$query));
    }
    
    public function searchEventsByDate($date){
	    $db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent where e.date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') AND e.publie AND e.date=:date ORDER BY e.date, e.attending DESC";
	    return $db->fetchAll($sql, array(':date'=>$date));
    }
    
    public function searchEventsByArtist($query){
	    $db = $this->getAdapter();
	    $query = '%'.$query.'%';
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM hapta_event_admin ad RIGHT JOIN hapta_event e ON e.id = ad.idEvent RIGHT JOIN ( SELECT DISTINCT e2.id FROM hapta_event e2 RIGHT JOIN hapta_event_artist hea ON e2.id=hea.idEvent RIGHT JOIN hapta_artist ha ON hea.idArtist=ha.idArtist WHERE ha.name LIKE :query ) as sub1 ON e.id=sub1.id LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent where e.date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') AND e.publie ORDER BY e.date, e.attending DESC ";
	    return $db->fetchAll($sql, array(':query'=>$query));
    }
    
    public function getFivePastEventsFromClub($idSpot){
    	$db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM (select distinct date from hapta_event where date<date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') and publie=1 order by date desc) as hd LEFT JOIN hapta_event e ON hd.date = e.date LEFT JOIN hapta_event_admin ad ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE e.publie = 1 AND e.idSpot=:idSpot ORDER BY e.attending DESC limit 5";
	    return $db->fetchAll($sql, array(':idSpot'=>$idSpot));
    }
    
    public function getFiveUpcomingEventsFromClub($idSpot){
    	$db = $this->getAdapter();
	    $sql = "SELECT DISTINCT e.id, e.name, e.linkFb, e.publie, e.heureDebut, e.heureFin, e.date, e.attending, e.img, cl.id as idSpot, cl.name as nameSpot, cl.city as city, cl.address as address, co.idConcours, co.idPostConcours FROM (select distinct date from hapta_event where date>=date_format(date_add(now(), INTERVAL -5 hour),'%Y-%m-%d') and publie=1 order by date desc) as hd LEFT JOIN hapta_event e ON hd.date = e.date LEFT JOIN hapta_event_admin ad ON e.id = ad.idEvent LEFT JOIN hapta_club cl ON e.idSpot = cl.id LEFT JOIN hapta_concours co ON e.id = co.idEvent WHERE e.publie = 1 AND e.idSpot=:idSpot ORDER BY e.attending DESC limit 5";
	    return $db->fetchAll($sql, array(':idSpot'=>$idSpot));
    }
}

