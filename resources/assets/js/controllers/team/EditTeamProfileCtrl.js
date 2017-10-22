(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('EditTeamProfileCtrl',['$state', '$stateParams', 'User', 'Team', 'Auth', 'Division', 'City', 'Category', EditTeamProfileCtrl]);

	function EditTeamProfileCtrl($state, $stateParams, User, Team, Auth, Division, City, Category){
		var vm = this;
		// Methods
		vm.getCities = getCities;
		vm.getDivisions = getDivisions
		vm.getCategories = getCategories;
		vm.getTeamInfo = getTeamInfo;
		vm.editTeam = editTeam;
		vm.matchCategoryDesc = matchCategoryDesc
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
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
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
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		function getTeamInfo(){
			Team.getTeam($stateParams.id).then(function(data){
				if(data.success){
					console.log(data);
					vm.teamData = data.team;
					vm.teamData.cityId = data.team.city.id;
					vm.teamData.categoryId = data.team.category.id;
					vm.teamData.divisionId = data.team.division.id;
					console.log(vm.teamData);
				}else{
					console.warn(data.msg);
				}
			}, function(err){
				alert('Hubo un error en el servidor');
			});
		};
		function editTeam(){
			Team.editTeam(vm.teamData).then(function(data){
				if(data.success){
					$state.go('user.team-profile', {id: $stateParams.id});
				}else{
					console.warn(data.msg);
				}
			}, function(err){

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
		// Methods self invoking
		getCities();
		getCategories();
		getDivisions();
		getTeamInfo();
	};
})();
