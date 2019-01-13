<?php
function dateToFrench($date){
	$day = date("w",strtotime($date));
	$dayNum = date("j",strtotime($date));
	$month = date("n",strtotime($date));
	$dayTxt = "";
	$monthTxt = "";
	
	//echo "Day : ". $day;
	//echo "month : ". $month;
	
	switch($day){
		case 1: $dayTxt="Lundi"; break;
		case 2: $dayTxt="Mardi"; break;
		case 3: $dayTxt="Mercredi"; break;
		case 4: $dayTxt="Jeudi"; break;
		case 5: $dayTxt="Vendredi"; break;
		case 6: $dayTxt="Samedi"; break;
		case 0: $dayTxt="Dimanche"; break;
	}
	
	switch($month){
		case 1: $monthTxt="Janvier"; break;
		case 2: $monthTxt="Février"; break;
		case 3: $monthTxt="Mars"; break;
		case 4: $monthTxt="Avril"; break;
		case 5: $monthTxt="Mai"; break;
		case 6: $monthTxt="Juin"; break;
		case 7: $monthTxt="Juillet"; break;
		case 8: $monthTxt="Août"; break;
		case 9: $monthTxt="Septembre"; break;
		case 10: $monthTxt="Octobre"; break;
		case 11: $monthTxt="Novembre"; break;
		case 12: $monthTxt="Décembre"; break;
	}
	
	return $dayTxt ." ". $dayNum ." ". $monthTxt;
}


function getNbEventsForDate($date, $array) {
	foreach($array as $elt){
		if($elt["date"] == $date){
			return $elt["nbEvents"];
		}
	}
	return "";
}

?>