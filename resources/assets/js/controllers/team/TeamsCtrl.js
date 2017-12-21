(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamsCtrl',['Team', TeamsCtrl]);

	function TeamsCtrl(Team){
		var vm = this;
		// Props
		vm.teams = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			divisions: ['Junior', 'Senior'],
			categories: ['Violencia contra la niñez', 'Bienestar y salud', 'Educación'],
			teamThat: {
				requestMembers: true,
				requestMentors: true,
			},
		};
		// Methods
		vm.getTeams = getTeams;
		vm.updateFilter = updateFilter;
		vm.isLoading = true;
		// Methods implementation
		function getTeams(){
			Team.getTeams().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.teams = data.teams;
				}else{
					alert(data.msg);
					vm.isLoading = false;					
				}
			}, function(err){
				vm.isLoading = false;
				alert('Hubo un error al obtener a los equipos, inténtelo nuevamente');
			});
		};
		function updateFilter(type, arg){
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};
		// Methods self invoking
		getTeams();
	};
})();
