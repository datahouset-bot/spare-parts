$(document).ready(function(){
    $('input').focus(function(){
      $(this).css({'background-color':'azure',
      'font-weight': 'bold',
      'font-size': '22px'

      });

      
    });

    $('select').focus(function(){
        $(this).css({'background-color':'azure',
        'font-weight': 'bold',
        'font-size': '18px'
          });
  
        
      });

      $( ".date" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
  
             
      }).datepicker('setDate','0');
      $( ".date_plus_1" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
  
             
      }).datepicker('setDate','1');



  });

//  time entery close------java script code --------------------------------------

      document.addEventListener("DOMContentLoaded", function() {
const checkinTimeInput = document.getElementById('checkin_time');
const checkoutTimeInput = document.getElementById('checkout_time');

// Set initial value to current time
const now = new Date();
const hours = String(now.getHours()).padStart(2, '0');
const minutes = String(now.getMinutes()).padStart(2, '0');
checkinTimeInput.value = `${hours}:${minutes}`;
checkoutTimeInput.value = checkinTimeInput.value;

// Update checkout time when checkin time changes
checkinTimeInput.addEventListener('input', function() {
    checkoutTimeInput.value = checkinTimeInput.value;
}); 
 });

     document.addEventListener("DOMContentLoaded", function() {
          const bookingTimeInput = document.getElementById('booking_time');
          const now = new Date();
          const hours = String(now.getHours()).padStart(2, '0');
          const minutes = String(now.getMinutes()).padStart(2, '0');
          bookingTimeInput.value = `${hours}:${minutes}`;
      });

//  time entery close--------------------------------------------

document.addEventListener("DOMContentLoaded", function() {
  const checkinTimeInput = document.getElementById('check_out_time');
  const now = new Date();
const hours = String(now.getHours()).padStart(2, '0');
const minutes = String(now.getMinutes()).padStart(2, '0');
checkinTimeInput.value = `${hours}:${minutes}`;

  



        });
  
  //  time entery close--------------------------------------------
  