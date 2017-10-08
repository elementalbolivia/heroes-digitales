(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Shirt', Shirt);
	Shirt.$inyect = ['$http', 'PUBLIC_URL'];
	function Shirt($http, PUBLIC_URL){
		return{
			getShirts: function(){
				var promise = $http({
					method: 'GET',
					url: PUBLIC_URL + 'shirts'
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
