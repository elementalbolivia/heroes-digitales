(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('HonorCodeCtrl',['$state', 'User', 'Auth', HonorCodeCtrl]);

	function HonorCodeCtrl($state, User, Auth){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.signature = {
			name: ''
		};
		// Methods
		vm.accept = accept;
		// Methods self invokation
		function accept(){
			User.acceptHonorCode({uid: vm.userCreds.id, name: vm.signature.name}).then(function(data){
				if(data.success){
					$state.go('user');
				}else{
					alert('Hubo un error inténtelo nuevamente');
				}
			}, function(err){
				alert('Hubo un error en el servidor');
			});
		};
	};
})();
