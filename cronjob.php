<?php

/*	
	BT-TO-to-iCal
	Copyright (C) 2020 Jannis Hutt

	@author Jannis Hutt
	@email github@jh0.eu
	@description retrieve schedule from bundestag.de, parse it, save it to database

*/

error_reporting(E_ALL);

require("to.php");

/*
	Test-Beispiel:
*/

//Status der DB checken
$todb = new TODB();

if (!$todb::isSetUp()) {
	$todb::createDB();
}

// Daten für Kalenderwoche 3 holen
$data = new FetchTOs(3, 2020)::fetch();

// Parsen
$parse = new Parser($data);

$sitzungen = $parse::findTOs();
//$tops = $parse::findTOPs();

// Speichern der TOs in der Datenbank
foreach ($sitzungen as $key => $sitzung) {
	
	$alreadySaved = $todb::inDB($sitzung);

	if($alreadySaved){

		$todb::update($sitzung);

	}else{

		$todb::insert($sitzung);
		
	}

}

