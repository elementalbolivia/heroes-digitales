(function(){
  angular.module('heroesDigitalesApp')
    .controller('HomeCtrl', [HomeCtrl]);
  function HomeCtrl(){
    var vm = this;
    vm.organizers = [
      'auspiciadores-02.png',
      'auspiciadores-03.png',
    ];
    vm.sponsors = [
      'auspiciadores-04.png',
      'auspiciadores-05.png',
      'auspiciadores-06.png',
      'auspiciadores-07.png',
      'auspiciadores-08.png',
      'auspiciadores-09.png',
      'auspiciadores-10.png',
      'auspiciadores-11.png',
    ];
  };
})();
