<?php

class Application_Model_User
{
	private $_dataTable;
	protected $_idUserFb;
	protected $_email;
	protected $_birthday;
	protected $_fullName;
	protected $_firstName;
	protected $_familyName;
	
	public function __construct(array $options = null)
    {
    	$this->_dataTable = new Application_Model_DbTable_User();
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
    public function setIdUserFb($id){
	    $this->_idUserFb = $id;
	    return $this;
    }
    
    public function setEmail($email){
	    $this->_email = $email;
	    return $this;
    }
    
    public function setBirthday($date){
	    $this->_birthday = $date;
	    return $this;
    }
    
    public function setFullName($name){
	    $this->_fullName = $name;
	    return $this;
    }
    
    public function setFirstName($name){
	    $this->_firstName = $name;
	    return $this;
    }
    
    public function setFamilyName($name){
	    $this->_familyName = $name;
	    return $this;
    }


    //GETTERS
    public function getIdUserFb(){
	    return $this->_idUserFb;
    }
    
    public function getEmail(){
	    return $this->_email;
    }
    
    public function getBirthday(){
	    return $this->_birthday;
    }
    
    public function getFullName(){
	    return $this->_fullName;
    }
    
    public function getFamilyName(){
	    return $this->_familyName;
    }
    
    public function getFirstName(){
	    return $this->_firstName;
    }
    
    
    public function getUserInfo($userId){
	    return $this->_dataTable->getUser($userId)->toArray();
    }
    
    public function editUserInfo($data, $userId){
	    $this->_dataTable->editUser($data, $userId);
    }

}

