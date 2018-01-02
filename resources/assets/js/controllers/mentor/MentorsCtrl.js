(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorsCtrl',['$stateParams', 'User', 'Mentor', MentorsCtrl]);
	function MentorsCtrl($stateParams, User, Mentor){
		var vm = this;
		// Props
		vm.mentors = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			withTeam: false,
			skills: ['AppInventor', 'Java', 'Android', 'Diseño', 'Documentación', 'Emprendimiento'],
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
			Mentor.getMentors(vm.currentPage).then(function(data){
				if(data.success){
					vm.isLoading = false;
					vm.mentors = data.mentors;
					vm.total = data.pages;
					console.log(data.pages);
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
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};
		// Methods self invoking
		getMentors();
	};
})();
