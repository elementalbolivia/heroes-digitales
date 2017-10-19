(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('CreateTeamCtrl',['$state', 'City', 'Category', 'Division', 'Team', 'Auth', CreateTeamCtrl]);

	function CreateTeamCtrl($state, City, Category, Division, Team, Auth){
		var vm = this;
		// Methods
		vm.getCities = getCities;
		vm.getDivisions = getDivisions
		vm.getCategories = getCategories;
		vm.sendRegistration = sendRegistration;
		// Props
		vm.isNotRegistered = {
			state: false,
			msg: '',
			isLoading: false,
		};
		vm.dataRegister = {
			idLeader: Auth.getSession().id,
			teamName: '',
			projectName: '',
			desc: '',
			cityId: 0,
			categoryId: 0,
			divisionId: 0,
			img: {},
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
		function sendRegistration(){
			vm.isNotRegistered.state = false;
			vm.isNotRegistered.isLoading = true;
			// Validar que el retype es igual al password
			Team.registerTeam(vm.dataRegister).then(function(data){
				if(data.success){
					Auth.setHasTeam(true);
					Auth.setIsLeader(true);
					Auth.setTeamId(data.team_id);
					$state.go('user');
				}else{
					vm.isNotRegistered.state = true;
					vm.isNotRegistered.isLoading = false;
					vm.isNotRegistered.msg = data.msg;
				}
			}, function(err){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.isLoading = false;
				vm.isNotRegistered.msg = data.msg;
			});
		};
		// Method self invoking
		getCities();
		getCategories();
		getDivisions();
	};
})();
