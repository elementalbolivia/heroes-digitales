(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('TeamFilter', TeamFilter);
	function TeamFilter(){
		return function(teams, city, division, category, requestMembers, requestMentors){
			// Filtrar en base a un hash
			var hash = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < teams.length; i++) {
				if((requestMembers && !teams[i].is_full) || (!requestMembers && teams[i].is_full) )
					hash[teams[i].id] = teams[i];
				if((requestMentors && !teams[i].has_mentor) || (!requestMentors && teams[i].has_mentor) )
					hash[teams[i].id] = teams[i];
				for (var j = 0; j < city.length; j++) {
					if(teams[i].city.nombre == city[j] )
						hash[teams[i].id] = teams[i];
				}
				for (var j = 0; j < division.length; j++) {
					if(teams[i].division.nombre == division[j] )
						hash[teams[i].id] = teams[i];
				}
				for (var j = 0; j < category.length; j++) {
					if(teams[i].category == null || teams[i].category == undefined)
						continue;
					if(teams[i].category.nombre == category[j] ){
						hash[teams[i].id] = teams[i];
					}
				}
			}
			var filtered = [];
			for (var i in hash) {
				filtered.push(hash[i]);
			};
			return filtered;
		};
	}
})();
