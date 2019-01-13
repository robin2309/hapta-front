<?php
	header("Content-Type: text/html; charset=UTF-8");
	include_once('accessModel.simpleClass.php');
	include_once('host.php');

	// Récupération de la date
	$res = $model->getDatesForEvent();
	foreach($res as $resultat_date)
	{	
		/// On récupère la date de la base de donnée
		$date_new = $resultat_date['date'];
		
		// Requete pour recupérer les events par rapport a la date précédemment récupéré
		$resu=$model->getEventFromDateNew($date_new);
		foreach($resu as $resultat_event)
		{
			$id_event  = $resultat_event['id'];
			$linkfb   = $resultat_event['linkFb'];

			// Explode pour recupérer l'id de l'event facebook sans l'adresse compléte
			$getIdEventFromFull = $linkfb;
			$idEvent = explode("/", $getIdEventFromFull);

			// Utilisation du graph facebook pour récupérer tout les champs des participants
			$count = file_get_contents("https://graph.facebook.com/v2.1/".$idEvent[4]."/?fields=attending_count&access_token=CAAFJWaxvuA8BABAm2RAHkARJiy3AjqXI4IiWYIPD6ds5l93sf1yUEsNSHrZCAdALKF3YKR1KxOZBttZAecdSqZA6UsCf34HUumvUqkZAyWHWyHKndQtkZA1nTk1ROqAyZB2vOwk96g4iZC0pNPPaVUCmk8KbWi2tbZByLx6qKZA8n0ptMgYZBrivru79RsgmiTwtKvDrF6hf3VyEQZDZD");
			$getNbAttengindEventFb = json_decode($count, true);
			$totalNbAttending = $getNbAttengindEventFb['attending_count'];

			// echo $idEvent[4]."<br />";
			// echo $totalNbAttending."<br />";
			// echo $id_event."<br /><br /><br />";

			// On update dans la base de donnée le nombre de participant
			$model->UpdateEventAttending($totalNbAttending, $id_event);
		}
	}
	echo "Fini";
?>