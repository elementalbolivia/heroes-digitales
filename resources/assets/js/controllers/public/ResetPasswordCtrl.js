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
			console.log(vm.passwordParams);
			if(!checkPassword(vm.passwordParams.password, vm.passwordParams.retype)){
				vm.isSubmited.state = true;
				vm.isSubmited.msg = 'Las contraseñas no coinciden';
				return;
			}
			vm.isSubmited.state = false;
			vm.isSubmited.isLoading = true;
			User.resetPassword(vm.passwordParams).then(function(data){
				if(data.success){
					$state.go('home.success-reset-password');
				}else{
					vm.isSubmited.isLoading = false;
					vm.isSubmited.msg = data.msg;
				}
			}, function(err){
				alert('Hubo un error en el servidor');
			});
		};
		function checkPassword(password, retype){
			if(password != retype)
				return false;
			return true;
		};
	};
})();
