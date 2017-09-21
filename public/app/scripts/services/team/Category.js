(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Category', Category)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/v1/')
		.constant('AUTH_URL', 'http://localhost:8000/api/v1/auth/');
	Category.$inyect = ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL'];
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