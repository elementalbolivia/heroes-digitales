(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('EditProfileCtrl', ['$state', 'User', 'City', 'Auth', 'Expertise', 'Skill', EditProfileCtrl]);

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
		vm.updateSuccess = {
			state: false,
			msg: ''
		}
		// Methods
		vm.getUserData = getUserData;
		vm.getCities = getCities;
		vm.getSkills = getSkills;
		vm.getExpertises = getExpertises;
		vm.update = update;
		vm.validateChars = validateChars;
		var validateRequired = validateRequired;
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
				alert('Hubo un error al realizar los cambios');
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
			if(!validateRequired(vm.userData)){
				vm.updateSuccess.state = true;
				vm.updateSuccess.msg = 'No puedes dejar los campos con * en vacío';
				return;
			}
			if(vm.userCreds.role == 1 || vm.userCreds.role == 4){
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
		function validateRequired(data){
			console.log(data);
			if(data.names == undefined || data.lastnames == undefined || data.zone == undefined || data.cellphone == undefined){
				console.log('basic info');
				return false;
			}
			if(data.role_id == 1){
					if(data.student.school == '' || data.student.school == undefined){
						return false;
					}
			}else if(data.role_id == 2){
				// todo
			}
			return true;
		}
		function validateChars(bioText){
			if(bioText.length > 2000){
				vm.userData.bio = vm.userData.bio.substr(0, 2000);
				return;
			}
		}
		// Methods self invoking
		getUserData();
		getCities();
		getSkills();
		getExpertises();
	};
})();
