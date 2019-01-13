<?PHP
//classe Modele d'event

class Application_Model_Event{
	private $_dataTable;
	protected $_id;
	protected $_name;
	protected $_spot;
	protected $_linkFb;
	protected $_prices;
	protected $_linkTicket;
	protected $_publie;
	protected $_heureDebut;
	protected $_heureFin;
	protected $_date;
	protected $_img;
	protected $_attending;
	protected $_admins;
	protected $_artists;
	protected $_idConcours;
	protected $_concours;
	protected $_genres;
	
	//TODO
	//ajout classe spot dans attributs
	
	
    public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_Event();
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
	public function setId($id){
		$this->_id = $id;
		return $this;
	}
	
	public function setName($name){
		$this->_name = $name;
		return $this;	
	}
	
	public function setSpot($spot){
		$this->_spot = $spot;
		return $this;
	}
	
	public function setLinkFb($link){
		$this->_linkFb = $link;
		return $this;
	}
	
	public function setPrices($price){
		$this->_price = $price;
		return $this;
	}
	
	public function setLinkTicket($link){
		$this->_linkTicket = $link;
		return $this;
	}
	
	public function setPublie($publie){
		$this->_publie = $publie;
		return $this;
	}
	
	public function setHeureDebut($heure){
		$this->_heureDebut = $heure;
		return $this;
	}
	
	public function setHeureFin($heure){
		$this->_heureFin = $heure;
		return $this;
	}
	
	public function setDate($date){
		$this->_date = $date;
		return $this;
	}
	
	public function setImg($img){
		$this->_img = $img;
		return $this;
	}
	
	public function setAttending($attending){
		$this->_attending = $attending;
		return $this;
	}
	
	public function setGenres($genre){
		$this->_genre = $genre;
		return $this;		
	}
	
	public function setAdmins($admins){
		$this->_admins = $admins;
		return $this;
	}
	
	public function setArtists($artists){
		$this->_artists = $artists;
		return $this;
	}
	
	public function setIdConcours($concours){
		$this->_concours = $concours;
		return $this;
	}
	
	public function setConcours($concours){
		$this->_concours = $concours;
		return $this;
	}
	
	//GETTERS
	public function getId(){
		return $this->_id;
	}
	
	public function getName(){
		return $this->_name;
	}
	
	public function getSpot(){
		return $this->_spot;
	}
	
	public function getLinkFb(){
		return $this->_linkFb;
	}
	
	public function getPrices(){
		return $this->_price;
	}
	
	public function getLinkTicket(){
		return $this->_linkTicket;
	}
	
	public function getPublie(){
		return $this->_publie;
	}
	
	public function getHeureDebut(){
		return $this->_heureDebut;
	}
	
	public function getHeureFin(){
		return $this->_heureFin;
	}
	
	public function getDate(){
		return $this->_date;
	}
	
	public function getImg(){
		return $this->_img;
	}
	
	public function getAttending(){
		return $this->_attending;
	}
	
	public function getGenres(){
		return $this->_genre;
	}
	
	public function getAdmins(){
		return $this->_admins;
	}
	
	public function getArtists(){
		return $this->_artists;
	}
	
	public function getIdConcours(){
		return $this->_concours;
	}
	
	public function getConcours(){
		return $this->_concours;
	}
	
	
	private function prepareResultSet($result){
	   	$entries   = array();
	   	$prices = new Application_Model_PriceEvent();
	   	$artists = new Application_Model_Artist();
	   	$genres = new Application_Model_GenreEvent();
	   	$spot = new Application_Model_Spot();
	   	$concours = new Application_Model_Concours();
	   	
	   	if(is_array(reset($result))){//if array -> more than one row
		   	foreach ($result as $row) {
	            $entry = new Application_Model_Event($row);
	            $spot = new Application_Model_Spot(array('id'=>$row['idSpot'],'name'=>$row['nameSpot'],'city'=>$row['city'],'address'=>$row['address']));
	            
	            $entry->setArtists($artists->getArtistsFromEvent($row['id']))
	            	  ->setGenres($genres->getGenresEvent($row['id']))
	            	  ->setSpot($spot)
	            	  ->setPrices($prices->getPricesEvent($row['id']))
	            	  ->setConcours(new Application_Model_Concours($row));
	            
	            $entries[] = $entry;
	        }
	        return $entries;
	   	} elseif(count($result) > 0) { // if not array, 1 row
		   	$event = new Application_Model_Event($result);
            $event->setArtists($artists->getArtistsFromEvent($result['id']))
            	  ->setGenres($genres->getGenresEvent($result['id']))
            	  ->setSpot(new Application_Model_Spot($spot->getSpot($result['idSpot'])))
            	  ->setPrices($prices->getPricesEvent($result['id']))
            	  ->setConcours(new Application_Model_Concours($concours->getConcoursFromEvent($result['id'])));
            return $event;
	   	}
	   	return array();
    }
	
	public function getUpcomingEvents(){
		$retrievedEvents = $this->_dataTable->getEventsStart();
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getUpcomingEventsMore($date){
		$retrievedEvents = $this->_dataTable->getEventsMore($date);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getNbEvents(){
		return $this->_dataTable->getNbEventsByDate();
	}
	
	public function getNbEventsMore($date){
		return $this->_dataTable->getNbEventsByDateMore($date);
	}
	
	public function getEventsFromSearch($query){
		$retrievedEvents = $this->_dataTable->searchEvents($query);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getEventsFromSearchDate($date){
		$retrievedEvents = $this->_dataTable->searchEventsByDate($date);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getEventsFromSearchArtist($query){
		$retrievedEvents = $this->_dataTable->searchEventsByArtist($query);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	//METHODE POUR L'APP
	public function getUpcomingEventsJson(){
		$events = $this->_dataTable->getEventsStart();
		$prices = new Application_Model_PriceEvent();
	   	$artists = new Application_Model_Artist();
	   	$genres = new Application_Model_GenreEvent();
		for($i=0; $i<count($events); $i++){
			$events[$i]['artists'] = $artists->getArtistsArrayFromEvent($events[$i]['id']);
			$events[$i]['genres'] = $genres->getGenresEvent($events[$i]['id']);
			$events[$i]['prices'] = $prices->getPricesEventArray($events[$i]['id']);
		}
		return $events;
	}

	public function getNbEventsJson(){
		return $this->_dataTable->getNbEventsByDate();
	}
	
	public function getUpcomingEventsMoreJson($date){
		$events = $this->_dataTable->getEventsMore($date);
		$prices = new Application_Model_PriceEvent();
	   	$artists = new Application_Model_Artist();
	   	$genres = new Application_Model_GenreEvent();
		for($i=0; $i<count($events); $i++){
			$events[$i]['artists'] = $artists->getArtistsArrayFromEvent($events[$i]['id']);
			$events[$i]['genres'] = $genres->getGenresEvent($events[$i]['id']);
			$events[$i]['prices'] = $prices->getPricesEventArray($events[$i]['id']);
		}
		return $events;
	}
	
	public function getNbEventsMoreJson($date){
		return $this->_dataTable->getNbEventsByDateMore($date);
	}
	
	public function getEventDetails($id){
		$retrievedEvents = $this->_dataTable->getEvent($id);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getFivePastEventsFromClub($idSpot){
		$retrievedEvents = $this->_dataTable->getFivePastEventsFromClub($idSpot);
		return $this->prepareResultSet($retrievedEvents);
	}
	
	public function getFiveUpcomingEventsFromClub($idSpot){
		$retrievedEvents = $this->_dataTable->getFiveUpcomingEventsFromClub($idSpot);
		return $this->prepareResultSet($retrievedEvents);
	}

}

?>