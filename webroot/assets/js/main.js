  

  $(document).ready(function(){
        $('.icon-menu').click(function(){
          // sidebar menu toggole
          $('#sidebar').toggleClass('visible');
           $("#button-swip").toggleClass("arrow");
        });
  });

    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        todayHighlight: true
    });

    $('#datetimepicker12').datepicker({
        todayHighlight: true,
        inline: true,
        sideBySide: true
    });




     // /*=======================================
     //    Datepicker init
     //  =========================================*/

     //  $('.datepicker-f').datetimepicker({
     //    format: "DD/MM/YYYY",
     //    icons: {
     //      up: 'fa fa-angle-up',
     //      down: 'fa fa-angle-down',
     //      previous: 'fa fa-angle-left',
     //      next: 'fa fa-angle-right',
     //    }
     //  });

     //  /*=======================================
     //    Timepicker init 
     //  =========================================*/

     //    $('.timepicker-f').datetimepicker({
     //    format: "HH:mm A",
     //    icons: {
     //      up: 'fa fa-angle-up',
     //      down: 'fa fa-angle-down',
     //      previous: 'fa fa-angle-left',
     //      next: 'fa fa-angle-right',
     //    }
     //  });

     
