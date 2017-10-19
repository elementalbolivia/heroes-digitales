(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Category', ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL',Category]);
	function Category($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getCategories: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'categories',
					params: {token: Auth.getSession().token}
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
