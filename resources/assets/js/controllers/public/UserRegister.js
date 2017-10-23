(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
	.controller('UserRegisterCtrl', ['$stateParams', '$state', 'City', 'Shirt', 'Genre', 'Register', 'LxNotificationService', UserRegisterCtrl]);

	function UserRegisterCtrl($stateParams, $state, City, Shirt, Genre, Register, LxNotificationService){
		var vm = this;
		// Methods
		vm.getCities = getCities;
		vm.getGenres = getGenres;
		vm.getShirts = getShirts;
		vm.generateYears = generateYears;
		vm.sendRegistration = sendRegistration;
		vm.validateSocialNetwork = validateSocialNetwork;
		var setRegProps = setRegProps;
		var retypePassword = retypePassword;
		var validateCV = validateCV;
		// Props
		vm.typeReg = $stateParams.type;
		vm.typeParams = {};
		vm.isNotRegistered = {
			state: false,
			msg: '',
			isLoading: false,
		};
		vm.dataRegister = {
			type: vm.typeReg,
			typeRegister: $stateParams.typeRegister,
			teamId: $stateParams.teamId,
			names: '',
			lastnames: '',
			birthDate: {
				day: 'Día',
				month: 'Mes',
				year: 'Año'
			},
			cellphone: '',
			cityId: 0,
			zone: '',
			genreId: 0,
			school: '',
			email: '',
			shirtId: 0,
			socialNetwork: '',
			password: '',
			retype: '',
			org: '',
			job: '',
			profession: '',
			cv: {},
		};
		vm.cities = [];
		vm.schools = [];
		vm.shirts = [];
		vm.genres = [];
		vm.dates = {
			days: [
				'Día',
				'01',
				'02',
				'03',
				'04',
				'05',
				'06',
				'07',
				'08',
				'09',
				'10',
				'11',
				'12',
				'13',
				'14',
				'15',
				'16',
				'17',
				'18',
				'19',
				'20',
				'21',
				'22',
				'23',
				'24',
				'25',
				'26',
				'27',
				'28',
				'29',
				'30',
				'31',
			],
			months: [
				'Mes',
				'01',
				'02',
				'03',
				'04',
				'05',
				'06',
				'07',
				'08',
				'09',
				'10',
				'11',
				'12',
			],
			years: ['Año']
		};
		// Declaration of methods
		/**
		 * setRegProps: Determina que tipo de usuario
		 * 				realizará un registro
		 * @param string type: Tipo de usuario
		 */
		function setRegProps(type){
			if(type == 'student'){
				vm.typeParams.title = 'Estudiante';
			}else if(type == 'mentor'){
				vm.typeParams.title = 'Mentor';
			}else if(type == 'judge'){
				vm.typeParams.title = 'Juez';
			}else if(type == 'expert'){
				vm.typeParams.title = 'Experto';
			}
			return;
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
		/*
		 * getCities: Hace la llamada al servicio Genre
		 * 			  para obtener los tipos de genero
		 * @return void
		 */
		function getGenres(){
			Genre.getGenres().then(function(data){
				if(data.success)
					vm.genres = data.genres;
				else
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		/*
		 * getCities: Hace la llamada al servicio Genre
		 * 			  para obtener los tipos de genero
		 * @return void
		 */
		function getShirts(){
			Shirt.getShirts().then(function(data){
				if(data.success)
					vm.shirts = data.shirts;
				else
					console.warn('Hubo un error al cargar los datos');
			}, function(err){
				console.error('Error en el servidor');
			});
		};
		function generateYears(){
			var actYear = new Date().getFullYear();
			for (var i = 1960; i <= actYear; i++) {
				vm.dates.years.push(i);
			};
			return;
		};
		function retypePassword(newPass, retype){
			if(newPass != retype){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.msg = 'Su contraseña no coincide, escribala nuevamente';
				return false;
			}
			return true;
		};
		function sendRegistration(){
			if(!Number.isInteger(Number(vm.dataRegister.cellphone))){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.msg = 'Debe introducir un número de teléfono';
				return;
			}
			if((vm.typeReg == 'judge' || vm.typeReg == 'expert')
					&& (!vm.validateSocialNetwork(vm.dataRegister.socialNetwork)
					|| !validateCV(vm.dataRegister.cv))) return;
			if(!retypePassword(vm.dataRegister.password, vm.dataRegister.retype)) return;
			vm.isNotRegistered.state = false;
			vm.isNotRegistered.isLoading = true;
			// Validar que el retype es igual al password
			Register.register(vm.dataRegister).then(function(data){
				if(data.success){
					if(data.emailSended == 'NOT_SENDED')
						LxNotificationService.alert('Felicitaciones', data.msg, 'OK', function(answer){ $state.go('home') });
					else
						$state.go('home.success-register');
				}else{
					vm.isNotRegistered.state = true;
					vm.isNotRegistered.isLoading = false;
					vm.isNotRegistered.msg = data.msg;
				}
			}, function(err){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.isLoading = false;
				vm.isNotRegistered.msg = 'Hubo un error al realizar su registro, revise su conexión a internet e inténtelo nuevamente';
			});
		};
		function validateSocialNetwork(text){
			if((text == undefined || text == '') || (text.search(/linkedin/i) == -1 && text.search(/facebook/i) == -1)){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.msg = 'Debes enlazar tu cuenta de Facebook o LinkedIn';
				return false;
			}else{
				vm.isNotRegistered.state = false;
			}
			return true;
		}
		function validateCV(cv){
			if(angular.equals(cv, {})){
				vm.isNotRegistered.state = true;
				vm.isNotRegistered.msg = 'Debes subir tu curriculum vitae';
				return false;
			}else{
				vm.isNotRegistered.state = false;
			}
			return true;
		}
		// Self execution functions
		setRegProps(vm.typeReg);
		getCities();
		getShirts();
		getGenres();
		generateYears();
	};
})();
