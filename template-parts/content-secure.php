<?php
if (!is_user_logged_in()) :
wp_referer_field();
?>

<script type="text/javascript">
  $(document).ready(function() {

    $('.coupled.modal')
      .modal({
        closable  : false,
        allowMultiple: false
      })
    ;

    $('.loginModal.modal')
      .modal('attach events', '.modal.opensignupmodal .openLoginModal')
    ;

    $('.ui.modal.opensignupmodal')
      .modal('attach events', '.modal.loginModal .goback')
      .modal('show')
    ;

    var refererrer = $('input[name="_wp_http_referer"]').val();

    $("#modal-login").on('submit', function(e){
      e.preventDefault();
      var referrer = $('input[name="_wp_http_referer"]').val();

      $(this).hide();

      $("#login-status").html('<div class="ui icon info message"><i class="notched circle loading icon"></i><div class="content"><div class="header">Just one second</div>Please wait while we log you in.</div></div>');

      var form                                    =   {
          _wpnonce:                                   $("#_wpnonce").val(),
          action:                                     "shure_user_login",
          email:                                      $("#login-form-email").val(),
          password:                                   $("#login-form-password").val()
      };

      $.post( MLA.ajax_url, form ).always(function(data){

          if( data.status == 2 ){
              $("#login-status").html('<div class="ui icon success message"><i class="notched check icon"></i><div class="content"><div class="header">Success! Logging in...</div></div></div>');
              location.href                       =   MLA.home_url + referrer;
          }else{
              $("#login-status").html(
                  '<div class="ui icon error message"><i class="attention circle icon"></i>' +
                  'Unable to login. Please try again with a different email/password.' +
                  '</div>'
              );
              $('#modal-login').show();
          }
      });
    });
  });

</script>
<?php endif; ?>
