jQuery(function ($){
   'use strict';
   $('input[name="cf7_wc_products[choose_type]"]').on('change', function(){
      let el = $(this).parents()[1];
      if ($('#registrable').is(':checked')){
         $(el).next().hide();
      } else {
         $(el).next().show();
      }
    });
   $(window).on('load', function(){
      $('input[name="cf7_wc_products[choose_type]"]').trigger('change');
   });
});