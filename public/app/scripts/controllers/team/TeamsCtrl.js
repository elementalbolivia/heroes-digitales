(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamsCtrl', TeamsCtrl);
	TeamsCtrl.$inyect = ['Team'];

	function TeamsCtrl(Team){
		var vm = this;
		// Props
		vm.teams = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			divisions: ['Junior', 'Senior'],
			categories: ['Medio ambiente'],
			teamThat: {
				requestMembers: true,
				requestMentors: true,
			},
		};
		// Methods
		vm.getTeams = getTeams;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getTeams(){
			Team.getTeams().then(function(data){
				if(data.success){
					console.log(data);
					vm.teams = data.teams;
				}else{
					alert(data.msg);
				}
			}, function(err){

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