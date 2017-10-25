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
		// Methods
		vm.getMentors = getMentors;
		vm.updateFilter = updateFilter;
		// Methods implementation
		function getMentors(){
			Mentor.getMentors().then(function(data){
				if(data.success){
					vm.mentors = data.mentors;
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
		getMentors();
	};
})();
