<?php

class Application_Model_Concours
{
	protected $_id;
	protected $_dateDeb;
	protected $_dateFin;
	protected $_nbPlaces;
	protected $_nbGagnants;	
	protected $_imgConcours;
	protected $_name;
	protected $_publie;
	protected $_valide;
	protected $_idPostConcours;
	protected $_event;
	protected $_dataTable;

    public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_Concours();
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
    
    //SETTERS
	public function setIdConcours($id){
		$this->_id = $id;
		return $this;
	}
	
	public function setDateDeb($date){
		$this->_dateDeb = $date;
		return $this;
	}
	
	public function setDateFin($date){
		$this->_dateFin = $date;
		return $this;
	}
	
	public function setNbPlaces($nb){
		$this->_nbPlaces = $nb;
		return $this;
	}
	
	public function setNbGagnants($nb){
		$this->_nbGagnants = $nb;
		return $this;
	}
	
	public function setImgConcours($img){
		$this->_imgConcours = $img;
		return $this;
	}
	
	public function setName($nom){
		$this->_name = $nom;
		return $this;
	}
	
	public function setPublie($publie){
		$this->_publie = $publie;
		return $this;
	}
	
	public function setValide($valide){
		$this->_valide = $valide;
		return $this;
	}
	
	public function setEvent($event){
		$this->_event = $event;
		return $this;
	}
	
	public function setIdPostConcours($id){
		$this->_idPostConcours = $id;
		return $this;
	}
	
	//GETTERS
	public function getIdConcours(){
		return $this->_id;
	}
	
	public function getDateDeb(){
		return $this->_dateDeb;
	}
	
	public function getDateFin(){
		return $this->_dateFin;
	}
	
	public function getNbPlaces(){
		return $this->_nbPlaces;
	}
	
	public function getNbGagnants(){
		return $this->_nbGagnants;
	}
	
	public function getImgConcours(){
		return $this->_imgConcours;
	}
	
	public function getName(){
		return $this->_name;
	}
	
	public function getPublie(){
		return $this->_publie;
	}
	
	public function getValide(){
		return $this->_valide;
	}
	
	public function getEvent(){
		return $this->_event;
	}
	
	public function getIdPostConcours(){
		return $this->_idPostConcours;
	}
	
	
	private function prepareResultSet($result){
	   	$entries   = array();
	   	$prices = new Application_Model_PriceEvent();
	   	$artists = new Application_Model_Artist();
	   	$genres = new Application_Model_GenreEvent();
        foreach ($result as $row) {
            $event = new Application_Model_Event($row);
            $spot = new Application_Model_Spot(array('id'=>$row['idSpot'],'name'=>$row['nameSpot'],'city'=>$row['city'],'address'=>$row['address']));
            $event->setArtists($artists->getArtistsFromEvent($row['id']))
            	  ->setGenres($genres->getGenresEvent($row['id']))
            	  ->setSpot($spot)
            	  ->setPrices($prices->getPricesEvent($row['id']));
            $entry = new Application_Model_Concours($row);
            $entry->setEvent($event);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function getCurrentConcours(){
		$result = $this->_dataTable->getCurrent();
		return $this->prepareResultSet($result);
	}
	
	public function getUpcomingConcours(){
		$result = $this->_dataTable->getUpcoming();
		return $this->prepareResultSet($result);
	}
	
	public function countCurrentConcours(){
		return $this->_dataTable->countCurrent();
	}
	
	public function countUpcomingConcours(){
		return $this->_dataTable->countUpcoming();
	}
	
	public function countAllConcours(){
		return $this->_dataTable->countAll();
	}
	
	//METHODE POUR L'APP
	public function getCurrentConcoursJson(){
		return $this->_dataTable->getCurrent();
	}
	
	public function getUpcomingConcoursJson(){
		return $this->_dataTable->getUpcoming();
	}
	
	public function getConcoursFromEvent($idEvent){
		$concours = $this->_dataTable->getConcoursFromEvent($idEvent);
		if(!$concours){
			return null;
		} else{
			return $concours;
		}
	}

}

