(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expert',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Expert]);
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
