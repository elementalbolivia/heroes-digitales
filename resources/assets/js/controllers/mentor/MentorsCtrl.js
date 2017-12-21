(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorsCtrl',['User', 'Mentor', MentorsCtrl]);
	function MentorsCtrl(User, Mentor){
		var vm = this;
		// Props
		vm.mentors = [];
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			withTeam: true,
			skills: ['AppInventor', 'Java', 'Android', 'Diseño', 'Documentación', 'Emprendimiento'],
		};
		vm.isLoading = true;
		// Methods
		vm.getMentors = getMentors;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getMentors(){
			Mentor.getMentors().then(function(data){
				if(data.success){
					vm.isLoading = false;					
					vm.mentors = data.mentors;
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
