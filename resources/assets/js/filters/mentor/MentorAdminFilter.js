(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('MentorAdminFilter', MentorAdminFilter);
	function MentorAdminFilter(){
		return function(mentors, withTeam){
      console.log(withTeam);
      if(withTeam === 'ALL') return mentors;
			// Filtrar en base a un hash
			var hashMentors = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < mentors.length; i++) {
				var eligible = [];
				if(mentors[i].has_team == withTeam) eligible.push(true);
				else eligible.push(false);

				if(eligible.indexOf(false) === -1)
					hashMentors[mentors[i].id] = mentors[i];
			}
			var filtered = [];
			for (var i in hashMentors) {
				filtered.push(hashMentors[i]);
			};
			return filtered;
		};
	}
})();
