(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.filter('StudentAdminFilter', StudentAdminFilter);
	function StudentAdminFilter(){
		return function(students, withTeam){
      console.log(withTeam);
      if(withTeam === 'ALL') return students;
			// Filtrar en base a un hash
			var hashStudents = {};
			// En cada coincidencia que exista con alguno de los parametros
			// del filtro, crear una llave unica en el hash
			// si existe otro con la misma llave, no se repite en hash
			// o se sobreescribe
			for (var i = 0; i < students.length; i++) {
				var eligible = [];
				if(students[i].has_team == withTeam) eligible.push(true);
				else eligible.push(false);

				if(eligible.indexOf(false) === -1)
					hashStudents[students[i].id] = students[i];
			}
			var filtered = [];
			for (var i in hashStudents) {
				filtered.push(hashStudents[i]);
			};
			return filtered;
		};
	}
})();
