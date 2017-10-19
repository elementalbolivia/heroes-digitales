(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Genre',['$http', 'PUBLIC_URL', Genre]);
	function Genre( $http, PUBLIC_URL){
		return{
			getGenres: function(){
				var promise = $http({
					method: 'GET',
					url: PUBLIC_URL + 'genres'
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
