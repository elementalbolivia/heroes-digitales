(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Request', Request)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/')
		.constant('AUTH_URL', 'http://localhost:8000/api/auth/');
	Request.$inyect = ['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth'];
	function Request($http, PUBLIC_URL, AUTH_URL, Auth){
		return{
			confirmRequest: function(data){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'request',
					data: data,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();