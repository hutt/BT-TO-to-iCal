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
	- Fortschritt des Gesetzentwurfs (Beratung, Erste Beratung, Zweite Beratung, Dritte Beratung)
	- TOP-Typ und Anzahl der TOP-Typen (Antrag, Beschlussempfehlung, Bericht, Gesetzentwurf)
	- Akteure (Bundesregierung, Bundesrat, Ausschuss, Fraktion(en))
	- Gremien (Ausschuss/Ausschüsse, Enquête-Kommission(en), etc.)
	- verlinkte Drucksachen & Drs.-Nr.
	- Abstimmungs-Art
		- keine
		- einfach
		- namentlich
		- geheim (nur bei Personalentscheidungen)
	- zugehöriger Artikel auf bundestag.de
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
