<?php

/*	
	BT-Tagesordnung handlen
	Copyright (C) 2020 Jannis Hutt

	@author Jannis Hutt
	@email github@jh0.eu
	@description retrieve schedule from bundestag.de, parse it, filter events for specific information, save it, update saved events

	class TOP ( )
		public id
		public name
		public begin
		public end
		public description
		public sitzungsNummer
		public drucksachen
		public gremien
		public akteure
		public abstimmung
		public url

		__construct ( begin, end, name, description )
			return void

		abstract protected filterFor ( search )
			return void

		protected filterForID ( )
			return void

		…


	class TO ( )
		public week
		public year
		protected tops

		public parseHTML ( html )
			return void

		public parseJSON ( json )
			return void

		public exportJSON ( week, year )
			return JSON_export

		public update ( week, year )
			return void

		public write ( week, year )
			return void

		public delete ( week, year )
			return void

		public needsUpdates ( week, year )
			return boolean


	class FetchData ( week, year )
		protected week
		protected year

		__construct ( week, year )
			return void

		public setWeek ( week )
			return void

		public setYear ( year )
			return void

		protected buildRequestURL ( date )
			returns url

		public fetch ( )
			return HTML_site
*/

