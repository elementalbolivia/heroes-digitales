(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Category', Category);
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