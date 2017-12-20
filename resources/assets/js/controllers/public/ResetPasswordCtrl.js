(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
	.controller('ResetPasswordCtrl', ['$state', '$stateParams', 'User', ResetPasswordCtrl]);

	function ResetPasswordCtrl($state, $stateParams, User){
		var vm = this;
		// Props
		vm.passwordParams = {
			password: '',
			retype: '',
			uid: $stateParams.id,
			token: $stateParams.token,
		};
		vm.isSubmited = {
			state: false,
			msg: '',
			isLoading: false,
		};
		// Methods
		vm.resetPassword = resetPassword;
		var checkPassword = checkPassword;
		// Methods implementation
		function resetPassword(){
			vm.isSubmited.state = false;
			if(!checkPassword(vm.passwordParams.password, vm.passwordParams.retype)){
				vm.isSubmited.state = true;
				vm.isSubmited.msg = 'Las contraseñas no coinciden';
				return;
			}
			vm.isSubmited.isLoading = true;
			User.resetPassword(vm.passwordParams).then(function(data){
				if(data.success){
					$state.go('home.success-reset-password');
				}else{
					vm.isSubmited.isLoading = false;
					vm.isSubmited.msg = data.msg;
					vm.isSubmited.state = true;
				}
			}, function(err){
				vm.isSubmited.isLoading = false;
				vm.isSubmited.msg = 'Hubo un error en el servidor, inténtelo nuevamente';
				vm.isSubmited.state = true;
			});
		};
		function checkPassword(password, retype){
			if(password != retype)
				return false;
			return true;
		};
	};
})();
