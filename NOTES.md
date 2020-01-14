Notizen
=======

Todo-Liste
----------

### Daten holen
- [ ] TO von bundestag.de parsen
	- wird in strukturierter Form bereitgestellt unter `https://www.bundestag.de/apps/plenar/plenar/conferenceweekDetail.form?year={Jahr}&week={Kalenderwoche}`.
- [ ] Unterscheiden lernen zwischen historischen TOs, die nicht mehr aktualisiert werden und TOs, bei denen regelmäßig nach einer aktuelleren Version geschaut werden muss.
	- historische TO:
		- `Kalenderwoche von TO-Datum` < `Kalenderwoche von heutigem Datum`
		- Kein Hinweis »Zwischen den Fraktionen besteht kein Einvernehmen über die Tagesordnung der {Sitzungsnummer}. Sitzung«
	- aktuelle TO: `Kalenderwoche von TO-Datum` >= `Kalenderwoche von heutigem Datum`
		- TO dieser Woche:
			- `Kalenderwoche von TO-Datum` == `Kalenderwoche von heutigem Datum`
		- TO einer kommenden Woche:
			- `Kalenderwoche von TO-Datum` > `Kalenderwoche von heutigem Datum`

### Daten verarbeiten
- [x] Format für Calendar Master File: JSON (`calendar-master.json`)
- [ ] historische TOs speichern
- [ ] aktuelle TOs aktualisieren
- [ ] \(optional) Methode zum manuellen Aktualisieren alter TOs
- [ ] \(optional) Tagesordnungspunkt analysieren auf
	- [ ] Fortschritt des Gesetzentwurfs (Beratung, Erste Beratung, Zweite Beratung, Dritte Beratung)
	- [ ] TOP-Typ und Anzahl der TOP-Typen (Antrag, Beschlussempfehlung, Bericht, Gesetzentwurf)
	- [ ] Akteure (Bundesregierung, Bundesrat, Ausschuss, Fraktion(en))
	- [ ] Gremien (Ausschuss/Ausschüsse, Enquête-Kommission(en), etc.)
	- [ ] verlinkte Drucksachen & Drs.-Nr.
	- [ ] Abstimmungs-Art
		- keine
		- einfach
		- namentlich
		- geheim (nur bei Personalentscheidungen)
	- [ ] zugehöriger Artikel auf bundestag.de
		- Bild holen
		- vielleicht ideal, um verlinkte Drucksachen abzurufen?


### Daten anzeigen
- [x] Feeds
	- [x] iCal
	- [x] RSS
	- [x] XML
	- [x] JSON
	- [x] HTML (Web Calendar)
	- [x] HTML-Fragment (`calendar-frag.html`)
- [ ] \(optional) als iCal-Export
	- [ ] Export-Funktion für einzelne Einträge
	- [ ] Filter-Funktion nach Gremium, Akteur(en), Art der Abstimmung
	- [ ] Export-Funktion für mehrere Einträge


# to.php

SETTINGS
	const DB_NAME // Name der DB

CLASSES

class TODB
==========

	VARS
	----
	protected db

	METHODS
	-------
	public __construct()::void
		this->db = open database (SQLite3->open())

	public checkStatus()::void
		checks if database file already exists.
		when not: runs createDB()

	public inDB( object )::boolean
		tells if object is already saved in db

	protected createDB()::void
		creates database with name 'DB_NAME'
		including tables 'tops' and 'sitzungen'


class FetchTOs
==============

	VARS
	----
	protected week
	protected year

	METHODS
	-------
	public __construct( week, year )::void
		sets parameter variables for class

	public fetch()::String[HTML_page]
		downloads page content as HTML

	protected buildRequestURL()::String[url]
		Builds URL in 'https://www.bundestag.de/apps/plenar/plenar/conferenceweekDetail.form?year={year}&week={week}'' scheme


class FetchTOPDetails
=====================

	VARS
	----
	protected articleUrl
	protected siteContents

	METHODS
	-------
	public __construct ( TOP )::void
		get TOP->artikelUrl to look for data

	protected download():String[HTML_page]
		downloads page content as HTML

	public getDrs()::Array()[Drs-Nr]
		returns array with all found Drs [Drs-Nr][Drs-URL]

	…


class Sitzung
=============

	VARS
	----
	public nr
	public week
	public year
	public updated

	METHODS
	-------
	public __construct ( nr, week, year )
		sets variables in class




class TOP
=========

	VARS
	----
	public begin
	public end
	public sitzungsNr
	public topNr
	public title
	public description
	public status
	public abstimmung
	public drs
	public gremien
	public akteure
	public artikelUrl
	public updated

	METHODS
	-------
	public __construct( begin, end, name, description, status )::void
		sets variables above + timestamp
