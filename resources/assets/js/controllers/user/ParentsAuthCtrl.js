(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('ParentsAuthCtrl', ['$state', 'User', 'Auth', 'LxNotificationService', ParentsAuthCtrl]);

	function ParentsAuthCtrl($state, User, Auth, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.parents = {
			signature: '',
			email: ''
		}
		// Methods
		vm.accept = accept;
		// Methods implementation
		function accept(){
			User.acceptParentsAuth({uid: vm.userCreds.id, signature: vm.parents.signature, email: vm.parents.email}).then(function(data){
				if(data.success)
				LxNotificationService.confirm('Autorización enviada', data.msg ,{
							ok: 'Entiendo'
					}, function(answer){
						if (answer)
							$state.go('user');
					});
				else
					alert(data.msg);
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		}
	};
})();
