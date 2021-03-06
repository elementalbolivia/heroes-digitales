(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Request', ['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth', Request]);
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
