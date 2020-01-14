<?php

/*	
	BT-TO-to-iCal
	Copyright (C) 2020 Jannis Hutt

	@author Jannis Hutt
	@email github@jh0.eu
	@description retrieve schedule from bundestag.de, parse it, save it to database

*/

require("to.php");

/*
	Test-Beispiel:
*/

//Status der DB checken
$todb = new TODB();

if (!$todb->checkStatus()) {
	$todb->createDB();
}

// Daten für Kalenderwoche 3
$data = new FetchTOs(3, 2020)->fetch();
$parse = new TOParser($data);

if($parse){
	//Parsen erfolgreich
	echo "Neue Daten erfolgreich geparst.";
}
