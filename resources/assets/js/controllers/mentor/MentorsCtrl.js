(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorsCtrl',['$stateParams', 'User', 'Mentor', MentorsCtrl]);
	function MentorsCtrl($stateParams, User, Mentor){
		var vm = this;
		// Props
		vm.mentors = [];
		vm.filters = {
			cities: $stateParams.cities.split(','),
			withTeam: $stateParams.wteam === 'true' ? true : false,
			mentorName: $stateParams.mentor,
			// skills: ['AppInventor', 'Java', 'Android', 'Diseño', 'Documentación', 'Emprendimiento'],
		};
		vm.total = 0;
		vm.pagination = [];
		vm.currentPage = $stateParams.num;
		vm.isLoading = true;
		// Methods
		vm.getMentors = getMentors;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getMentors(){
			vm.isLoading = true;
			Mentor.getMentors(vm.currentPage,
					{
						city: vm.filters.cities,
						withTeam: vm.filters.withTeam,
						mentorName: vm.filters.mentorName
					}).then(function(data){
				if(data.success){
					vm.isLoading = false;
					vm.mentors = data.mentors;
					vm.total = data.pages;
					vm.pagination = [];
					for (var i = 0; i < data.pages; i++) {
						vm.pagination.push(i + 1);
					}
				}else{
					vm.isLoading = false;
					alert(data.msg);
				}
			}, function(err){
				vm.isLoading = false;
				alert('Hubo un error al obtener a los mentores, inténtelo nuevmante');
			});
		};
		function updateFilter(type, arg){
			if(arg == 'TEXT'){
				getMentors();
				return;
			}
			if(type == 'withTeam'){
				vm.filters.withTeam = arg;
				getMentors();
				return;
			}
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
			getMentors();
		};
		// Methods self invoking
		getMentors();
	};
})();
