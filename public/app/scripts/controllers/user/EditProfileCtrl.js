(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('EditProfileCtrl', EditProfileCtrl);
	EditProfileCtrl.$inyect = ['$state', 'User', 'City', 'Auth', 'Expertise', 'Skill'];

	function EditProfileCtrl($state, User, City, Auth, Expertise, Skill){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.cities = [];
		vm.zones = [];
		vm.skills = [];
		vm.expertises = [];
		vm.skillsUser = [];
		// Methods
		vm.getUserData = getUserData;
		vm.getCities = getCities;
		vm.getSkills = getSkills;
		vm.getExpertises = getExpertises;
		vm.update = update;
		// Methods implementation
		function getUserData(){
			User.getInfo(vm.userCreds.id).then(function(data){
				if(data.success){
					vm.userData = data.user;
					vm.userData.bio = vm.userData.bio ? vm.userData.bio.name : '';
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		/**
		 * getCities: Hace la llamada al servicio City
		 * 			  para obtener las ciudades de la BD
		 * @return void
		 */
		function getCities(){
			City.getCities().then(function(data){
				if(data.success)
					vm.cities = data.cities;
				else
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		function getExpertises(){
			Expertise.getExpertises().then(function(data){
				if(data.success)
					vm.expertises = data.expertises;
				else
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		function getSkills(){
			Skill.getSkills().then(function(data){
				if(data.success){
					vm.skills = data.skills;
					vm.skillsUser = data.skills;
				}else{
					console.warn('Hubo un error al cargar los datos');
				}
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		function update(){
			if(vm.userCreds.role == 1){
				User.updateStudent(vm.userData, vm.userData.id).then(function(data){
					if(data.success){
						$state.go('user.my-profile');
					}else{
						alert('Hubo un error, inténtelo nuevamente');
					}
				}, function(err){
					alert('Hubo un error en servidor, revise su conexión a internet');
				});
			}else if(vm.userCreds.role == 2){
				var userData = vm.userData;
				userData.skills = vm.skillsUser;
				User.updateMenthor(userData, vm.userData.id).then(function(data){
				if(data.success){
						$state.go('user.my-profile');
					}else{
						alert('Hubo un error, inténtelo nuevamente');
					}
				}, function(err){
					alert('Hubo un error en servidor, revise su conexión a internet');
				});
			}
		};
		// Methods self invoking
		getUserData();
		getCities();
		getSkills();
		getExpertises();
	};
})();
