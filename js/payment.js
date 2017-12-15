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
