(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('EditTeamProfileCtrl',['$state', '$stateParams', 'User', 'Team', 'Auth', 'Division', 'City', 'Category', 'LxNotificationService', EditTeamProfileCtrl]);

	function EditTeamProfileCtrl($state, $stateParams, User, Team, Auth, Division, City, Category, LxNotificationService){
		var vm = this;
		// Methods
		vm.getCities = getCities;
		vm.getDivisions = getDivisions
		vm.getCategories = getCategories;
		vm.getTeamInfo = getTeamInfo;
		vm.editTeam = editTeam;
		vm.matchCategoryDesc = matchCategoryDesc
		vm.chooseCategoryImg = chooseCategoryImg;
		// Props
		vm.isSubmited = {
			state: false,
			msg: '',
			isLoading: false,
		};
		vm.teamData = {
			idLeader: $stateParams.idLeader,
			team_name: '',
			project_name: '',
			project_desc: '',
			city_d: 0,
			category_id: 0,
			division_id: 0,
		};
		vm.cities = [];
		vm.divisions = [];
		vm.categories = [];
		// Methods implementation
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
		/**
		 * getZoes: Hace la llamada al servicio Zone
		 * 			  para obtener las zonas de la BD
		 * @return void
		 */
		function getCategories(){
			Category.getCategories().then(function(data){
				if(data.success)
					vm.categories = data.categories;
				else
				LxNotificationService.warning('Hubo un error al obtener los datos de categorías, inténtelo nuevamente');
			}, function(err){
				LxNotificationService.error('Hubo un error al obtener los datos de categorías, revise su conexión a internet');
			});
		};
		/**
		 * getCities: Hace la llamada al servicio Genre
		 * 			  para obtener los tipos de genero
		 * @return void
		 */
		function getDivisions(){
			Division.getDivisions().then(function(data){
				if(data.success)
					vm.divisions = data.divisions;
				else
					LxNotificationService.warning('Hubo un error al cargar los datos de divisiones,inténtelo nuevamente');
			}, function(err){
				LxNotificationService.error('Hubo un error, revise su conexión a internet');
			});
		};
		function getTeamInfo(){
			Team.getTeam($stateParams.id).then(function(data){
				if(data.success){
					vm.teamData = data.team;
					vm.teamData.cityId = data.team.city.id;
					vm.teamData.categoryId = data.team.category.id;
					vm.teamData.divisionId = data.team.division.id;
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(err){
				LxNotificationService.error('Hubo un error al obtener los datos del equipo, revise su conexión a internet');
			});
		};
		function editTeam(){
			if(vm.teamData.divisionId == 0 || vm.teamData.cityId == 0){
				vm.isSubmited.state = true;
				vm.isSubmited.msg = 'No puede dejar los campos con * en vacío';
			}
			vm.isSubmited.isLoading = true;
			Team.editTeam(vm.teamData).then(function(data){
				vm.isSubmited.isLoading = false;
				if(data.success){
					$state.go('user.team-profile', {id: $stateParams.id});
				}else{
					vm.isSubmited.state = true;
					vm.isSubmited.msg = data.msg;
				}
			}, function(err){
				LxNotificationService.error('Hubo un error al realizar los cambios, revise su conexión a internet');
			});
		};
		function matchCategoryDesc(cid){
			for (var i = 0; i < vm.categories.length; i++) {
				if(vm.categories[i].id == cid){
					vm.categoryDesc = vm.categories[i].desc;
					return;
				}
			}
			vm.categoryDesc = 'Debe seleccionar una categoría para el equipo';
		}
		function chooseCategoryImg(id){
			var path = '/app/images/app-arts/categorias/';
			switch (id) {
				case 1:
					return path + '1.png';
				case 2:
					return path + '3.png';
				case 3:
						return path + '2.png';
				default:
					return;
			}
		}
		// Methods self invoking
		getCities();
		getCategories();
		getDivisions();
		getTeamInfo();
	};
})();
