<?PHP

class AccessModel
{
	private $_user;
	private $_password;
	private $_dsn;
	private $_link;
		
	public function __construct($user,$password,$dsn)
	{
		
		//$this->_abstractLayer=new ModelAbstractLayer($user,$password,$host,$database);
		$this->_user=$user;
		$this->_password=$password;
		$this->_dsn = $dsn;
		$this->_open_connection();
	}

	private function _open_connection()
	{
		if($this->_link==0)
		{
			try{
			
				$this->_link = new PDO($this->_dsn,$this->_user,$this->_password);
				$this->_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			} catch(PDOException $e){
                echo 'Erreur connexion DB';
            } 
		}
	}
	
	//fonction pour executer une requete preparee de type SELECT
	private function executeStmt($sql,$params){
		//on prepare le statement a executer avec la connexion courante et le sql passe en parametre a la fonction
		try{
			//on recupere la connexion et on initialise une requete preparee avec la chaine sql
			$stmt = $this->getLink()->prepare($sql);
			//on execute la requete preparee en passant le tableau parametre/valeurs 
			$stmt->execute($params);
			//on parcours le resultat pour avoir le resultat dans un tableau associatif
			$resultat = $stmt->fetchAll();
			//on detruit la requete preparee
			$stmt->closeCursor();
			return $resultat;
		} catch(PDOException $e){
			//enlever cela en production
            echo 'Erreur requete:';
        } 
	}
	
	//fonction pour executer une requete preparee de type:
	//INSERT, DELETE, ou UPDATE
	private function executeStmtTransac($sql,$params){
		try{
			$stmt = $this->getLink()->prepare($sql);
			$stmt->execute($params);
			$stmt->closeCursor();
		} catch(PDOEXception $e){
			//enlever cela en production
            echo 'Erreur requete';
		}
	}
	
	private function executeStmtTransacUserFb($sql,$params){
		try{
			$stmt = $this->getLink()->prepare($sql);
			$stmt->execute($params);
			$stmt->closeCursor();
		} catch(PDOEXception $e){
            if($e->getCode() == 23000){
	            return;
            } else {
	            echo 'Erreur requete';
            }
		}
	}
	
	//fonction pour executer une requete sans parametre 
	public function rechquery($query)
	{
		//on prepare le statement a executer avec la connexion courante et le sql passe en parametre a la fonction
		try{
			$stmt = $this->getLink()->prepare($query);
			$stmt->execute();
			//on parcours les resultats
			$resultat = $stmt->fetchAll();
			//necessaire?
			$stmt->closeCursor();
			return $resultat;
		} catch(PDOException $e){
                echo 'Erreur requete:';
        } 
		
	}
	
	//getter pour recuperer la connexion a la base
	private function getLink(){
		return $this->_link;
	}
	
	//inserer un nouvel user dans la table des users Facebook
	public function sauverDonneesUser($id, $email, $dateNaissance, $nom){
		$sql="INSERT INTO hapta_user_fb (idUserFb, email, birthday, fullName) VALUES (:id, :email, :dateNaissance, :nom)";
		$params = array(':id'=>$id, ':email'=>$email, ':dateNaissance'=>$dateNaissance, ':nom'=>$nom);
		$this->executeStmtTransacUserFb($sql,$params);
	}

}
?>