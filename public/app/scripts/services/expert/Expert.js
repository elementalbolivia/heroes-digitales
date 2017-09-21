(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expert', Expert);
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