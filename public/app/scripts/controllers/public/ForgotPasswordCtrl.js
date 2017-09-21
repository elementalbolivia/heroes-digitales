(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('ForgotPasswordCtrl', ForgotPasswordCtrl);
	ForgotPasswordCtrl.$inyect = ['$state', '$timeout', 'User', 'Auth'];

	function ForgotPasswordCtrl($state, $timeout, User, Auth){
		var vm = this;
		// Props
		vm.passwordParams = {
			password: ''
		};
		vm.isSubmited = {
			state: false,
			msg: '',
			isLoading: false,
		};
		// Methods
		vm.sendEmail = sendEmail;
		// Methods implementation
		function sendEmail(){
			vm.isSubmited.state = false;
			vm.isSubmited.isLoading = true;
			User.sendVerifEmail(vm.passwordParams).then(function(data){
				if(data.success){
					$state.go('home.success-email-verif');
				}else{
					vm.isSubmited.state = true;
					vm.isSubmited.isLoading = false;
					vm.isSubmited.msg = data.msg;
				}
			}, function(err){
				alert('Hubo un error en el servidor');
			});
		};
	};
})();