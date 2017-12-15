jQuery(document).ready(function($) {

  $(function() {
    $('a[href*="#"]:not([href="#"]):not(.mm-next)').click(function() {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length
          ? target
          : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });
  });

  $('.main.menu  .ui.dropdown').dropdown({on: 'hover'});

  $('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;

  $(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll >= 10) {
      $(".site-header").addClass("fixed-header");
    } else {
      $(".site-header").removeClass("fixed-header");
    }
  });

  $('.ui.accordion').accordion('refresh');

  $('.course-tabs.menu .item').tab();

  $('#done_watching').on('change', function(){
    $(document.body).css({'cursor' : 'progress'});
    var done = 1;
    if (!$(this).is(':checked')) {
      done = 0;
    }

    var form                =   {
            action:                 "shure_done_watching",
            done:                   done,
            post_id:                MLA.post_id,
            course_name:            MLA.course_name,
            next_video:             MLA.next
        };

        $.post( MLA.ajax_url, form ).always(function(data){
            if( data.status == 2 ){
                if (data.done == 1) {
                  console.log('Done Watching');
                } else {
                  console.log('Not Done');
                }
                location.reload();
            }else{
              console.log("Error");
            }
        });

  });

  $("#modal-signup").on('submit', function(e){
    e.preventDefault();

      $("#register-status").html(
          '<div class="ui icon info message"><i class="notched circle loading icon"></i><div class="content"><div class="header">Just one second</div>Please wait while we create your account.</div></div>'
      );
      $(this).hide();

      var form                =   {
          action:                                     "shure_create_account",
          fname:                                       $("#register-form-fname").val(),
          lname:                                       $("#register-form-lname").val(),
          email:                                       $("#register-form-email").val(),
          password:                                    $("#register-form-password").val(),
          confirm_pass:                                $("#register-form-repassword").val(),
          _wpnonce:                                    $("#_wpnonce").val()
      };

      console.log(form);

      $.post( MLA.ajax_url, form ).always(function(response){
          if( response.status == 2 ){
              $("#register-status").html('<div class="ui icon info message"><i class="notched circle loading icon"></i><div class="content"><div class="header">Just one second</div>Please wait while we log you in.</div></div>');
              location.href                       =   MLA.home_url + '/select-courses/';
          }else{
              $("#register-status").html(
                  '<div class="ui icon error message"><i class="attention circle icon"></i>' +
                  response.error +
                  '</div>'
              );
              $("#modal-signup").show();
          }
      });
  });

  $('#login-form').on( 'submit', function(e){
        e.preventDefault();

        $("#login-status").html('<div class="ui icon info message"><i class="notched circle loading icon"></i><div class="content"><div class="header">Just one second</div>Please wait while we log you in.</div></div>');

        var form                                    =   {
            _wpnonce:                                   $("#_wpnonce").val(),
            action:                                     "shure_user_login",
            email:                                      $("#login-form-email").val(),
            password:                                   $("#login-form-password").val()
        };

        $.post( MLA.ajax_url, form ).always(function(data){

            if( data.status == 2 ){
                $("#login-status").html('<div class="ui icon success message"><i class="notched check icon"></i><div class="content"><div class="header">Success!</div></div></div>');
                location.href                       =   MLA.dashboard_url;
            }else{
                $("#login-status").html(
                    '<div class="ui icon error message"><i class="attention circle icon"></i>' +
                    'Unable to login. Please try again with a different email/password.' +
                    '</div>'
                );
            }
        });
    });

    $('#logout-btn').on( 'click', function(e){
          e.preventDefault();

          $("#login-status").html('<div class="ui info message"><i class="spinner loading icon"></i> Please wait while we log you out.</div>');


          var form                                    =   {
              _wpnonce:                                   $("#_wpnonce").val(),
              action:                                     "shure_logout"
          };

          $.post( MLA.ajax_url, form ).always(function(data){

              if( data.status == 2 ){
                  $("#login-status").html('<div class="alert alert-success">Logout!</div>');
                  location.href                       =   MLA.home_url;
              }else{
                  $("#login-status").html(
                      '<div class="ui icon error message"><i class="attention circle icon"></i>' +
                      'Unable to logout.' +
                      '</div>'
                  );
              }
          });
      });

      $('.menu .signedin').on('click', function(e){
        e.preventDefault();
        var form                                    =   {
            _wpnonce:                                   MLA.ajax_nonce,
            action:                                     "shure_logout"
        };

        $.post( MLA.ajax_url, form ).always(function(data){
            if( data.status == 2 ){
                location.href                       =   MLA.home_url;
            }else{
                alert("Error Loging out");
            }
        });
      });

      $('#step1').on('click', function(e){

        e.preventDefault();
        var $this = $(this);
        $(this).html('<i class="spinner loading icon"></i>Loading...');

        $( "#step1" ).fadeOut( "slow", function() {
          $('#step2').removeClass("hidden");
        });

      });

      $('#step2').on('click', 'button.lightblue', function(e){
          e.preventDefault();

          var form                                    =   {
              _wpnonce:                                   MLA.ajax_nonce,
              key_stage:                                  $(this).attr('id'),
              action:                                     "shure_step2"
          };


          $.post( MLA.ajax_url, form ).always(function(data){
              if( data.status == 2 ){
                $( "#step2" ).fadeOut( "slow", function() {
                  $('#step3').fadeIn("slow", function(){
                    $('#step3').append(data.content);
                  });
                });
              }else{
                  console.log(data);
              }
          });

      });

      var totalPrice;
      var courseIds;

      function getSum(total, num) {
          return parseInt(total) + parseInt(num);
      }

      $("#step3").on('click', '#gostep2', function(e){
        e.preventDefault();
        $("#step4").fadeOut();
        $( "#step3" ).html("").fadeOut( "slow", function() {
          $('#step2').fadeIn("slow");
        });
      });

      $("#step3").on('change', ".courseId", function(){

        courseIds = $('input:checkbox:checked').map(function () {
          return this.value;
        }).get();

        var prices = $('input:checkbox:checked').map(function () {
          return this.getAttribute('data-price');
        }).get();

        if (courseIds.length > 0) {
          totalPrice = prices.reduce(getSum);
          $("#step4").fadeIn( function(){
            $("#tprice").text(totalPrice);
          });

          if (totalPrice > 0) {
            $("#paypal-button-container").show();
            $("#enrollfreecourse").hide();
          } else {
            $("#paypal-button-container").hide();
            $("#enrollfreecourse").show();
          }

        } else {
          $("#step4").fadeOut();
        }
      });

      $("#enrollfreecourse").on('click', function(e){
        e.preventDefault();

        if (totalPrice == 0) {          

          var form                                    =   {
              _wpnonce:                                   MLA.ajax_nonce,
              courses:                                    courseIds,
              action:                                     "shure_enroll_courses"
          };

          $.post( MLA.ajax_url, form ).always(function(data){
              if( data.status == 2 ){
                $('.ui.modal.enrolledModal')
                  .modal({ closable  : false })
                  .modal('show')
                ;
                location.href                       =   MLA.dashboard_url;
                console.log(data);
              }else{
                  console.log(data);
              }
          });

        } else {
          alert("Error!");
        }
      });

      if( $('#paypal-button-container').length ) {

        paypal.Button.render({

          env: 'sandbox', // sandbox | production

          style: {
              label: 'paypal',
              size:  'medium',    // small | medium | large | responsive
              shape: 'rect',     // pill | rect
              color: 'blue',     // gold | blue | silver | black
              tagline: true
          },

          // PayPal Client IDs - replace with your own
          // Create a PayPal app: https://developer.paypal.com/developer/applications/create
          client: {
              sandbox:    'AVPP-w06GgUOPqvLQFZk7T1YH3Yr1fUmekojaTMuTaILZVYPycM6-AVjLx3BVfMUwu7rNh-_klmf8c-e',
          },

          // Show the buyer a 'Pay Now' button in the checkout flow
          commit: true,

          // payment() is called when the button is clicked
          payment: function(data, actions) {

              // Make a call to the REST api to create the payment
              return actions.payment.create({
                  payment: {
                      transactions: [
                          {
                              amount: { total: totalPrice, currency: 'EUR' }
                          }
                      ]
                  }
              });
          },

          // onAuthorize() is called when the buyer approves the payment
          onAuthorize: function(data, actions) {

              // Make a call to the REST api to execute the payment
              return actions.payment.execute().then(function(data) {

                var form                                    =   {
                    _wpnonce:                                   MLA.ajax_nonce,
                    courses:                                    courseIds,
                    receipt:                                    data.id,
                    action:                                     "shure_enroll_courses"
                };

                $.post( MLA.ajax_url, form ).always(function(data){
                    if( data.status == 2 ){
                      $('.ui.modal.enrolledModal')
                        .modal({ closable  : false })
                        .modal('show')
                      ;
                      location.href                       =   MLA.dashboard_url;

                    }else{

                    }
                });
              });
          }

      }, '#paypal-button-container');

    }

});
