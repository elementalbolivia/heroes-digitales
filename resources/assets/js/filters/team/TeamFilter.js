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
				var eligible = [];
				if((requestMembers && !teams[i].is_full_students) || (!requestMembers && teams[i].is_full_students) )
					eligible.push(true);
				else
					eligible.push(false)

				if((requestMentors && !teams[i].is_full_mentors) || (!requestMentors && teams[i].is_full_mentors) )
					eligible.push(true);
				else
					eligible.push(false);

				if(city.indexOf(teams[i].city.nombre) >= 0) eligible.push(true);
				else eligible.push(false);

				if(division.indexOf(teams[i].division.nombre) >= 0) eligible.push(true);
				else eligible.push(false);

				if(teams[i].category != null){
					// console.log(category.indexOf(teams[i].category.nombre))
					if(category.indexOf(teams[i].category.nombre) >= 0)
						eligible.push(true);
					else
						eligible.push(false);
				}
				if(eligible.indexOf(false) == -1)
					hash[teams[i].id] = teams[i];
			}
			// console.log(hash);
			var filtered = [];
			for (var i in hash) {
				filtered.push(hash[i]);
			};
			return filtered;
		};
	}
})();
