<?php

/**	
	BT-TO-to-iCal
	Copyright (C) 2020 Jannis Hutt

	@author Jannis Hutt
	@email github@jh0.eu
	@description Classes for TO handling
**/

// Settings
// Name der DB mit Dateiendung
const DB_NAME = "to.db";
const DEBUG = true;

// Klassen
class Log {

	public function __construct($object, $cat, $msg){

		$class = get_class($object);
		$logmsg = $class . " [" . $cat . "]" . ": " . $msg;
		
		if(DEBUG){
			echo $logmsg;
		}

	}

}

class Sitzung {

	//class variables
	public $nr;
	public $week;
	public $year;
	public $startDate;
	public $updated;

	//methods
	public function __construct($nr, $week, $year, $startDate){
		self::$nr = $nr;
		self::$week = $week;
		self::$year = $year;
		self::$startDate = $startDate;
		self::$updated = time();
	}

}

class TOP {

	//class variables
	//from database
	public $dbid;
	//in constructor parameters
	public $start;
	public $end;
	public $sitzungsNr;
	public $topNr;
	public $title;
	public $description;
	public $status;
	//gets set in constructor method
	public $updated;
	//needs to be calculated
	public $duration;
	//needs to be fetched with FetchTOPDetails
	public $abstimmung;
	public $drs;
	public $gremien;
	public $akteure;
	public $artikelUrl;

	//methods
	public function __construct($start, $end, $sitzungsNr, $topNr, $title, $description, $status){

		self::$start = $start;
		self::$end = $end;
		self::$sitzungsNr = $sitzungsNr;
		self::$topNr = $topNr;
		self::$title = $title;
		self::$description = $description;
		self::$updated = time();

	}

	public function setDbid($dbid){

		self::$dbid = $dbid;

	}

}

class TODB {

	//class methods

	public static function insert($object){

		$object = self::escapeStringsInObject($object);

		switch ( get_class($object) ) {

			case 'TOP':
				return self::insertTOP($object);
				break;
			
			case 'Sitzung':
				return self::insertSitzung($object);
				break;

		}

	}

	private static function insertTOP($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "INSERT INTO tops (sitzungsNr, topNr, startTime, endTime, duration, title, description, status, abstimmung, drs, gremien, akteure, artikelUrl, updated) VALUES ($o->sitzungsNr, $o->topNr, $o->start, $o->end, $o->duration, $o->title, $o->description, $o->status, $o->abstimmung, $o->drs, $o->gremien, $o->akteure, $o->artikelUrl, $o->updated)";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg());
	      return false;
	   	} else {
	      new Log(self, "Success", "insertTOP() was successful.");
	      return true;
	   	}

		$db::close();

	}

	private static function insertSitzung($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "INSERT INTO sitzungen (sitzungsNr, week, year, startdate, updated) VALUES ($o->nr, $o->week, $o->year, $o->startDate, $o->updated)";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg());
	      return false;
	   	} else {
	      new Log(self, "Success", "insertSitzung() was successful.");
	      return true;
	   	}

		$db::close();
	}

	public static function update($object){

		$object = self::escapeStringsInObject($object);

		switch ( get_class($object) ) {

			case 'TOP':
				return self::updateTOP($object);
				break;
			
			case 'Sitzung':
				return self::updateSitzung($object);
				break;
		}

	}

	private static function updateTOP($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "UPDATE tops SET topNr = $o->topNr, startTime = $o->start, endTime = $o->end, duration = $o->duration, title = '$o->title', description = '$o->description', status = '$o->status', abstimmung = '$o->abstimmung', drs = '$o->drs', gremien = '$o->gremien', akteure = '$o->akteure', artikelUrl = '$o->artikelUrl', updated = $o->updated WHERE id = $o->dbid";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg() );
	      return false;
	   	} else {
	      new Log(self, "Success", $db::changes() . " – updateTOP() was successful.");
	      return true;
	   	}

		$db::close();
	}

	private static function updateSitzung($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "UPDATE sitzungen SET week = $o->week, year = $o->year, startdate = $o->startDate, updated = $o->updated WHERE sitzungsNr = $o->nr";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg());
	      return false;
	   	} else {
	      new Log(self, "Success", $db::changes() . " – updateSitzung() was successful.");
	      return true;
	   	}

		$db::close();
	}

	public static function delete($object){
		switch ( get_class($object) ) {
			case 'TOP':
				return self::deleteTOP($object);
				break;
			
			case 'Sitzung':
				return self::deleteSitzung($object);
				break;
		}
	}

	private static function deleteTOP($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "DELETE FROM tops WHERE id = $o->dbid";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg());
	      return false;
	   	} else {
	      new Log(self, "Success", $db::changes() . " – deleteTOP() was successful.");
	      return true;
	   	}

		$db::close();
	}

	private static function deleteSitzung($o){
		$db = new SQLite3();
		$db::open(DB_NAME);

		$query = "DELETE FROM sitzungen WHERE sitzungsNr = $o->nr";

		$r = $db::exec($query);
	   	
	   	if(!$r) {
	      new Log(self, "Error", $db::lastErrorMsg());
	      return false;
	   	} else {
	      new Log(self, "Success", $db::changes() . " – deleteSitzung() was successful.");
	      return true;
	   	}

		$db::close();
	}

	public static function isSetUp(){

		$db = new SQLite3();
		$db::open(DB_NAME);

		$result = $db::query("SELECT name FROM sqlite_master WHERE type= 'table'");
		$rows = count( $result::fetchArray() );

		$db::close();

		return ($rows < 2);

	}

	public static function isSaved( $object ){

		$db = new SQLite3();
		$db::open(DB_NAME);

		switch ( get_class( $object ) ) {
			case 'Sitzung':
				//Match with sitzungsNr
				$query = "SELECT * FROM sitzungen WHERE sitzungsNr = $object->nr";
				$index = "sitzungsNr";
				break;
			
			case 'TOP':
				//Match with title and sitzungsNr
				$query = "SELECT * FROM tops WHERE sitzungsNr = $object->sitzungsNr AND title = '$object->title' LIMIT 1";
				$index = "id";
				break;
		}

		$q = $db::query($query);
		$result = $q::fetchArray()[1];
		$result = $result[$index];

		$db::close();

		return $result;

	}

	private static function escapeStringsInObject($object){

		//iterate thourgh object values
		foreach ($object as $key => $o) {

			if(gettype($o) == "string"){
				$object[$key] = SQLite3::escapeString($o);
			}

		}

		return $object;

	}

	public static function createDB(){

		$db = new SQLite3();
		$db::open(DB_NAME);

		//Tabelle für Sitzungen erstellen
		$tableSitzungen ="
			CREATE TABLE IF NOT EXISTS sitzungen (
			    sitzungsNr INTEGER  PRIMARY KEY
			                        UNIQUE,
			    week       INTEGER  NOT NULL,
			    year       INTEGER  NOT NULL,
			    startdate  DATE 	NOT NULL,
			    updated    DATETIME
			);";

		//Tabelle für TOPs erstellen
		$tableTOPs = "
			CREATE TABLE IF NOT EXISTS tops (
			    id          INTEGER  PRIMARY KEY AUTOINCREMENT
			                         UNIQUE
			                         NOT NULL,
			    sitzungsNr  INTEGER  NOT NULL
			                         REFERENCES sitzungen (sitzungsNr),
			    topNr       INTEGER,
			    startTime   DATETIME NOT NULL,
			    endTime     DATETIME NOT NULL,
			    duration 	TIME,
			    title       TEXT     NOT NULL,
			    description TEXT,
			    status      STRING,
			    abstimmung  STRING,
			    drs       	TEXT,
			    gremien     TEXT,
			    akteure     TEXT,
			    artikelUrl  STRING,
			    updated     DATETIME
			);";

		$db::exec($tableSitzungen);
		$db::exec($tableTOPs);

		$db::close();

		new Log(self, "Success", "database created.");

	}

}

class FetchTOs {

	//class variables
	private $week;
	private $year;

	//methods
	public function __construct($week, $year){
		self::$week = $week;
		self::$year = $year;
	}

	public function fetch(){

		$url = self::buildRequestUrl();
		$c = curl_init($url);

		//curl_setopt($c, option, value);

		$html = curl_exec($c);

		$error = curl_error($c);

		if($error){
			new Log(self, "Error", " at download: " . $error);
		}else{
			new Log(self, "Success", "Download of Webpage successful.");
		}

		curl_close($c);

		return $html;

	}

	private function buildRequestUrl(){

		$url = "https://www.bundestag.de/apps/plenar/plenar/conferenceweekDetail.form?year=" . self::$year . "&week=" . self::$week;
		return $url;

	}

}

class FetchTOPDetails {

	//todo

}

class Parser {
	
	//class variables
	private $htmlpage;

	//methods
	public function __construct($html){
		self::$htmlpage = $html;
	}

	public function findTOs(){

		$sitzungen = array();

		$doc = DOMDocument::loadHTML(self::htmlpage);
		$xpath = new DOMXpath($doc);

		$tos = $xpath::query("/html/body/div[@class='bt-standard-content']/table");

		foreach ($tos as $key => $to) {
			//every TO is in one table

			//fetch date and Sitzungsnummer
			$nodeValue = $to->firstChild->firstChild->nodeValue; // "15. Januar 2020 (139. Sitzung)"

			//date
			$dateRegex = "([0-9]+\.\s[A-Za-z]+\s[0-9]{4})"; 
			preg_match($dateRegex, $nodeValue, $startDateMatches);
			$startDateText = array_values($startDateMatches[1])[0]; // "15. Januar 2020"

			//create TimeDate object with time from website
			$date = new TimeDate( self::parseDateFromBT($startDateText, "U") );

			//startDate
			$startDate = $date::format("Y-m-d");

			//Sitzungsnummer
			$nrRegex = "([0-9]+)(?=\.\sSitzung\))";
			preg_match($nrRegex, $nodeValue, $nrMatches);
			$sitzungsNr = array_values($nrMatches[1])[0]; // "139"

			//Week
			$week = $date::format("W");

			//Year
			$year = $date::format("Y");

			//Sitzungs-Object erzeugen
			$sitzung = new Sitzung($sitzungsNr, $week, $year, $startDate);

			//In Array schieben
			array_push($sitzungen, $sitzung);
		}

		return $sitzungen;

	}

	public function findTOPs(){

		//todo

	}

	private function parseDateFromBT($text, $outputFormat){
		//replace german month names with numeric representation of the month without leading zeroes
		// Input = "15. Januar 2020"
		preg_match("(A-Za-z)+", $text, $monthMatches);
		$month = array_values( $monthMatches[1] )[0]; // "Januar"

		switch ($month) {
			case 'Januar':
				$n = 1;
				break;

			case 'Februar':
				$n = 2;
				break;

			case 'März':
				$n = 3;
				break;

			case 'April':
				$n = 4;
				break;

			case 'Mai':
				$n = 5;
				break;

			case 'Juni':
				$n = 6;
				break;

			case 'Juli':
				$n = 7;
				break;

			case 'August':
				$n = 8;
				break;

			case 'September':
				$n = 9;
				break;

			case 'Oktober':
				$n = 10;
				break;

			case 'November':
				$n = 11;
				break;

			case 'Dezember':
				$n = 12;
				break;
		}

		$numDate = preg_replace("\s(A-Za-z)+\s", strval($n).".", $text); // "15.1.2020"
		
		$date = date_create_from_format("j.n.Y", $numDate);

		//return in output format
		return $date::format($outputFormat);
	}

}

?>
