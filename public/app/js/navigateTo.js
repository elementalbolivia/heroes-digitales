function navigate(id){
  $('html, body').animate({
      scrollTop: $(id).offset().top - 100
  }, 2000);
}
