(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expert', Expert)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/v1/')
		.constant('AUTH_URL', 'http://localhost:8000/api/v1/auth');
	Expert.$inyect = ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL'];
	function Expert($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getExperts: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'experts',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();