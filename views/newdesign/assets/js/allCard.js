$(document).ready(function () {
    'use strict';

initSettingData();

initCardData();


initSettingDataFirst();
initCardDataFirst();

initSettingDataSecond();
initCardDataSecond();

initSettingDataThird();
initCardDataThird();

// initScanData();
// initUnscanData();

// initscanUnscanDataNum();
  
$({counter: 0}).animate({counter: 5000}, {
 
  duration: 6000,
  easing:'linear',
  step: function() {    
  //  $('.totalCouponGenerated').text(Math.ceil(this.counter));
  //  $('.month1').text(Math.ceil(this.counter));
  //  $('.month2').text(Math.ceil(this.counter));
  //  $('.month3').text(Math.ceil(this.counter));
  //  $('.totalCouponScan').text(Math.ceil(this.counter));
  //  $('.totalCouponUnscan').text(Math.ceil(this.counter)); 

    
  },
  complete: function() {
    
  }
});


function initSettingData(){
      showPageLoader();
      $.ajax({  
          type: "POST",  
          url: API_URL+'/report/getTotalCouponGenerated',
          data: JSON.stringify({}),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          cache: false,
          success: function(response){  
              hidePageLoader();
                 
              if(response.success==1) {

                $("#totalCouponGenerated").removeClass("totalCouponGenerated");
            //    alert(response.data);
                  var number = response.data.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                  $('#totalCouponGenerated').html(number);

              } else {
                $('#totalCouponGenerated').html(0);
                
                  //alert(response.message);
              }
          }, 
          error: function(error, xhr){
              hidePageLoader();
              console.log('error', error);
              console.log('xhr', xhr);
          }
      });


    }

    
function initCardData(){
    showPageLoader();

    var mainCatOption = '';
    
    $.ajax({  
        type: "POST",  
        url: API_URL+'/report/getMonthsCouponGenerated',
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response){  
            hidePageLoader();
            if(response.success==1) {
          //   alert(response.data);
           //     $('.cardNum').html(response.data);
                
            $("#month1").removeClass("month1");
            $("#month2").removeClass("month2");
            $("#month3").removeClass("month3");

                $.each(response.data, function(i, object){
                  //  mainCatOption +='<p>' +object.num+'</p>';

                    var number = object.num.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                    mainCatOption +='<p class ="mb-0"><span style="font-weight:700;float:left;width:160px;">' + object.monthName + ' ' + object.year + '</span> : &nbsp&nbsp&nbsp<span class="col-green">' +number+ '</span></p>';
                  });

                  $('.cardNum').html(mainCatOption);
                 

            } else {
              $('.cardNum').html(0);
                //alert(response.message);
            }
        }, 
        error: function(error, xhr){
            hidePageLoader();
            console.log('error', error);
            console.log('xhr', xhr);
        }
    });


  }



// Start First plant data


function initSettingDataFirst(){
  showPageLoader();
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/totalCouponGeneratedFirst',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
             
          if(response.success==1) {

            $("#totalCouponGeneratedFirst").removeClass("totalCouponGeneratedFirst");
        //    alert(response.data);
              var number = response.data.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
              $('#totalCouponGeneratedFirst').html(number);

          } else {
            $('#totalCouponGeneratedFirst').html(0);
            
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });


}

   
function initCardDataFirst(){
  showPageLoader();

  var mainCatOption = '';
  
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/getMonthsCouponGeneratedFirst',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
          if(response.success==1) {
        //   alert(response.data);
         //     $('.cardNumFirst').html(response.data);
              
          $("#monthFirst1").removeClass("monthFirst1");
          $("#monthFirst2").removeClass("monthFirst2");
          $("#monthFirst3").removeClass("monthFirst3");

              $.each(response.data, function(i, object){
                //  mainCatOption +='<p>' +object.num+'</p>';
                  var number = object.num.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                  mainCatOption +='<p class ="mb-0"><span style="font-weight:700;float:left;width:160px;">' + object.monthName + ' ' + object.year + '</span> : &nbsp&nbsp&nbsp<span class="col-green">' +number+ '</span></p>';
                });

                $('.cardNumFirst').html(mainCatOption);               

          } else {
            $('.cardNumFirst').html(0);
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });

}

// End First plant data




// Start Second plant data

function initSettingDataSecond(){
  showPageLoader();
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/totalCouponGeneratedSecond',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
             
          if(response.success==1) {

            $("#totalCouponGeneratedSecond").removeClass("totalCouponGeneratedSecond");
        //    alert(response.data);
              var number = response.data.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
              $('#totalCouponGeneratedSecond').html(number);

          } else {
            $('#totalCouponGeneratedSecond').html(0);
            
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });


}

   
function initCardDataSecond(){
  showPageLoader();

  var mainCatOption = '';
  
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/getMonthsCouponGeneratedSecond',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
          if(response.success==1) {
        //   alert(response.data);
         //     $('.cardNumFirst').html(response.data);
              
          $("#monthSecond1").removeClass("monthSecond1");
          $("#monthSecond2").removeClass("monthSecond2");
          $("#monthSecond3").removeClass("monthSecond3");

              $.each(response.data, function(i, object){
                //  mainCatOption +='<p>' +object.num+'</p>';
                 var number = object.num.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                  mainCatOption +='<p class ="mb-0"><span style="font-weight:700;float:left;width:160px;">' + object.monthName + ' ' + object.year + '</span> : &nbsp&nbsp&nbsp<span class="col-green">' +number+ '</span></p>';
                });

                $('.cardNumSecond').html(mainCatOption);               

          } else {
            $('.cardNumSecond').html(0);
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });

}

// End Second plant data



// Start Third plant data

function initSettingDataThird(){
  showPageLoader();
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/totalCouponGeneratedThird',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
             
          if(response.success==1) {

            $("#totalCouponGeneratedThird").removeClass("totalCouponGeneratedThird");
        //    alert(response.data);
              var number = response.data.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
              $('#totalCouponGeneratedThird').html(number);

          } else {
            $('#totalCouponGeneratedThird').html(0);
            
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });


}

   
function initCardDataThird(){
  showPageLoader();

  var mainCatOption = '';
  
  $.ajax({  
      type: "POST",  
      url: API_URL+'/report/getMonthsCouponGeneratedThird',
      data: JSON.stringify({}),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function(response){  
          hidePageLoader();
          if(response.success==1) {
        //   alert(response.data);
         //     $('.cardNumFirst').html(response.data);
              
          $("#monthThird1").removeClass("monthThird1");
          $("#monthThird2").removeClass("monthThird2");
          $("#monthThird3").removeClass("monthThird3");

              $.each(response.data, function(i, object){
                //  mainCatOption +='<p>' +object.num+'</p>';
                  var number = object.num.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                  mainCatOption +='<p class ="mb-0"><span style="font-weight:700;float:left;width:160px;">' + object.monthName + ' ' + object.year + '</span> : &nbsp&nbsp&nbsp<span class="col-green">' +number+ '</span></p>';
                });

                $('.cardNumThird').html(mainCatOption);               

          } else {
            $('.cardNumThird').html(0);
              //alert(response.message);
          }
      }, 
      error: function(error, xhr){
          hidePageLoader();
          console.log('error', error);
          console.log('xhr', xhr);
      }
  });

}

// End Third plant data




  // start scan Unscan data
/*
  function initScanData(){
    showPageLoader();
    $.ajax({  
        type: "POST",  
        url: API_URL+'/report/getTotalScanCoupon',
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response){  
            hidePageLoader();
            if(response.success==1) {

              
            $("#totalCouponScan").removeClass("totalCouponScan");
              
          //    alert(response.data);
                var number = response.data.replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
                $('#totalCouponScan').html(number);
            } else {
              $('#totalCouponScan').html(0);
                //alert(response.message);
            }
        }, 
        error: function(error, xhr){
            hidePageLoader();
            console.log('error', error);
            console.log('xhr', xhr);
        }
    });

  }

  function initUnscanData(){
    showPageLoader();
    $.ajax({  
        type: "POST",  
        url: API_URL+'/report/getTotalUnscanCoupon',
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response){  
            hidePageLoader();
            if(response.success==1) {

              
            $("#totalCouponUnscan").removeClass("totalCouponUnscan");
              
          //    alert(response.data);
                $('#totalCouponUnscan').html(response.data);
            } else {
              $('#totalCouponUnscan').html(0);
                //alert(response.message);
            }
        }, 
        error: function(error, xhr){
            hidePageLoader();
            console.log('error', error);
            console.log('xhr', xhr);
        }
    });

  }
*/
  // end scan unscan data

  // start scan - Unscan data num
/*
  function initscanUnscanDataNum(){
   
    showPageLoader();

    var mainCatOption = '';
    
    $.ajax({  
        type: "POST",  
        url: API_URL+'/report/getMonthScanUnscanNum',
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        success: function(response){  
            hidePageLoader();
            if(response.success==1) {
          //   alert(response.data);
           //     $('.cardNum').html(response.data);
                
          //  $("#month1").removeClass("month1");
          //  $("#month2").removeClass("month2");
          //  $("#month3").removeClass("month3");

              var ii = 1;
                $.each(response.data, function(keys, object){
                 
                  //  mainCatOption +='<p>' +object.num+'</p>';
                  
                    mainCatOption +=' <p class ="mb-0"> : <span class="col-green scanMonth'+ ii +'" id="scanMonth'+ ii +'">'+ keys +'</span> / <span class="col-green unscanMonth'+ ii +'" id="unscanMonth'+ ii +'">'+ object +'</span></p>';

                    ii++;
                            
                  });

                  $('.scanUnscanNums').html(mainCatOption);
                 

            } else {
              $('.scanUnscanNums').html(0);
                //alert(response.message);
            }
        }, 
        error: function(error, xhr){
            hidePageLoader();
            console.log('error', error);
            console.log('xhr', xhr);
        }
    });


  }

  */

  // end scan - Unscan data num



});

