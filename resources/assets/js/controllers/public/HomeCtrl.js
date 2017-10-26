(function(){
  angular.module('heroesDigitalesApp')
    .controller('HomeCtrl', ['Stage', HomeCtrl]);
  function HomeCtrl(Stage){
    var vm = this;
    // Methods
		vm.getStages = getStages;
		// Methods implementation
		function getStages(){
			Stage.getStages().then(function(data){
				if(data.success){
					vm.stages = data.stages;
				}else{
					alert(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		// Methods self invoking
    vm.organizers = [
      'auspiciadores-02.png',
      'auspiciadores-03.png',
    ];
    vm.sponsors = [
      'auspiciadores-06.png',
      'auspiciadores-05.png',
      'auspiciadores-07.png',
      'auspiciadores-08.jpg',
      'auspiciadores-04.png',
      'auspiciadores-10.png',
      'auspiciadores-12.png',
      'auspiciadores-13.jpg',
      'auspiciadores-11.png',
    ];
    vm.getStages();

  };
})();
