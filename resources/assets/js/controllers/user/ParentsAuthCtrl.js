(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('ParentsAuthCtrl', ['$state', '$timeout', 'User', 'Auth', 'LxNotificationService', ParentsAuthCtrl]);

	function ParentsAuthCtrl($state, $timeout, User, Auth, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.parents = {
			signature: '',
			email: ''
		};
		vm.sended = {
			isLoading: false,
			msg: '',
			title: '',
			success: false,
		};
		// Methods
		vm.accept = accept;
		vm.redirect = redirect;
		// Methods implementation
		function accept(){
			vm.sended.isLoading = true;
			User.acceptParentsAuth({uid: vm.userCreds.id, signature: vm.parents.signature, email: vm.parents.email}).then(function(data){
				$('#parentsModal').modal('show');
				vm.sended.isLoading = false;
				vm.sended.title = data.title;
				if(data.success){
					vm.parents = {
						signature: '',
						email: ''
					};
					vm.sended.msg = data.msg;
					vm.sended.success = true;
				}else{
					vm.sended.msg = data.msg;
					vm.sended.success = false;
				}
			}, function(err){
				LxNotificationService.error('Hubo un error en el servidor, revise su conexión a internet');
			});
		}
		function redirect(bool){
			if(bool){
				$timeout(function(){
					$state.go('user');
				}, 500);
			}else{
				return;
			}
		}
	};
})();
