jQuery(document).ready(function() {
    var owl = jQuery('.owl-carousel');
    owl.owlCarousel({
      margin: 30,
      nav: false,
      loop: true,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1023: {
          items: 3
        }
      }
    })
  
})