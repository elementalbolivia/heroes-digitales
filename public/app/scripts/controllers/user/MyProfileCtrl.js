(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MyProfileCtrl', MyProfileCtrl);
	MyProfileCtrl.$inyect = ['User', 'Auth'];

	function MyProfileCtrl(User, Auth){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.userImg = {
			newImg: null
		};
		// Methods
		vm.getUserData = getUserData;
		vm.updateImg = updateImg;
		// Methods implementation
		function getUserData(){
			User.getInfo(vm.userCreds.id).then(function(data){
				if(data.success){
					console.log(data.user);
					vm.userData = data.user;
				}else{
					alert(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		function updateImg(){
			User.updateImage({img: vm.userImg.newImg}, vm.userCreds.id).then(function(data){
				if(data.success){
					vm.userImg.newImg = null;
					getUserData();
				}else{
					console.warn(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		// Methods self invoking
		getUserData();
	};
})();