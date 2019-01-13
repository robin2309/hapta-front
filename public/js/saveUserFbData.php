<?PHP
	include_once('accessModel.simpleClass.php');
	include_once('../../routine/host.php');
	
	$id=$_GET['fbId'];
	$email=$_GET['email'];
	$date=$_GET['dateNaissanceBonFormat'];
	$nom=$_GET['nomFull'];
	
	if($email == 'null') $email = "";
	
	$model->sauverDonneesUser($id, $email, $date, $nom);
?>