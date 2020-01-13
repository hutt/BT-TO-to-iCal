<?php

/*	
	BT-Tagesordnung handlen
	Copyright (C) 2020 Jannis Hutt

	@author Jannis Hutt
	@email github@jh0.eu
	@description retrieve schedule from bundestag.de, parse it, filter events for specific information, save it, update saved events

	class TOData ( )
		protected week
		protected year
		protected sitzungen

		__construct ( week, year )
			return void

		public isCached ( )
			return boolean 

		public load ( )
			return void

		protected update ( )
			return void

		protected write ( )
			return void

		protected delete ( )
			return void

		protected buildRequestURL ( )
			returns url

		protected fetch ( )
			return json


	class TOP ( )
		public begin
		public end
		public nr
		public title
		public description
		public drucksachen
		public gremien
		public akteure
		public abstimmung
		public artikelUrl

		__construct ( begin, end, name, description )
			return void

		abstract protected filterFor ( search )
			return void

		protected filterForID extends filterFor ( )
			return void

		…


	class TO ( )
		public week
		public year
		public sitzungsnummer
		protected tops

		public needsUpdates ( week, year )
			return boolean

*/

