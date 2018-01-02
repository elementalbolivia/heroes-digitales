(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('MentorFilter', MentorFilter);
	function MentorFilter(){
		return function(mentors, city, withTeam, skills){
			// Filtrar en base a un hash
			var hashmentors = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < mentors.length; i++) {
				var eligible = [];
				if(mentors[i].has_team == withTeam){
					eligible.push(true);
					// hashmentors[mentors[i].id] = mentors[i];
				}else{
					eligible.push(false);
				}

				if(city.indexOf(mentors[i].city.nombre) != -1)
					eligible.push(true);
				else
					eligible.push(false);

				// for (var j = 0; j < city.length; j++) {
				// 	if(mentors[i].city.nombre == city[j])
				// 		hashmentors[mentors[i].id] = mentors[i];
				// }


				// for (var j = 0; j < skills.length; j++) {
				// 	for (var g = 0; g < mentors[i].mentor.skills.length; g++) {
				// 		if(skills.indexOf(mentors[i].mentor.skills[g].skill_name) != -1){
				// 			eligible.push(true);
				// 			continue;
				// 		}else{
				// 			eligible.push(false);
				// 		}
				// 		// if(mentors[i].mentor.skills[g].skill_name == skills[j]) {
				// 		// 	hashmentors[mentors[i].id] = mentors[i];
				// 		// }
				// 	}
				// }
				if(eligible.indexOf(false) == -1)
					hashmentors[mentors[i].id] = mentors[i];
			}
			var filtered = [];
			for (var i in hashmentors) {
				filtered.push(hashmentors[i]);
			};
			return filtered;
		};
	}
})();
