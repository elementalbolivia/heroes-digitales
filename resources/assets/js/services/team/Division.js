(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Division', ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL',Division]);
	function Division($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getDivisions: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'divisions',
					params: {token: Auth.getSession().token}
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
