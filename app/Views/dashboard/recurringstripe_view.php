<style type="text/css">
    .formErrors {
        padding: 10px 15px;
        width: auto;
        background: #fdeded;
        border: 1px solid #ffd3d3;
        margin: 10px 0 20px 0;
        max-width: 600px;
        color: #cc4747;
    }
    .error{
      color: #ff0000 !important;
    }
    /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  background-color: white;
  height: 20px;
  padding: 10px 12px;
  border-radius: 4px;
  border: 1px solid transparent;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}


button {
  border: none;
  border-radius: 4px;
  outline: none;
  text-decoration: none;
  color: #fff;
  background: #32325d;
  white-space: nowrap;
  display: inline-block;
  height: 40px;
  line-height: 40px;
  padding: 0 14px;
  box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
  border-radius: 4px;
  font-size: 15px;
  font-weight: 600;
  letter-spacing: 0.025em;
  text-decoration: none;
  -webkit-transition: all 150ms ease;
  transition: all 150ms ease;
  float: left;
  margin-left: 12px;
  margin-top: 28px;
}

button:hover {
  transform: translateY(-1px);
  box-shadow: 0 7px 14px rgba(50, 50, 93, .10), 0 3px 6px rgba(0, 0, 0, .08);
  background-color: #43458b;
}

</style>
<div class="rightArea">
    <div class="heading">
        <h2>Add Client : </h2>
    </div>
    <?php //For all the errors of server side validations
    if (isset($addRecurringPlanOutput) && !$addRecurringPlanOutput['status']) {
    ?>
    <div class="db-alert db-alert-danger flashHide">
        <strong><?php print_r($addRecurringPlanOutput['response']['messages'][0]); ?></strong> 
    </div>  
<?php } ?>

<div class="editFields fs-add-discount-box">

<form action="" method="post" id="payment-form">
  <div class="form-group">
    <label>First Name<span class="mandatory"> *</span></label>
    <input type="text" class="textfield" name="firstname" id="firstname" value="">
    <span></span>
  </div>

  <div class="form-group">
    <label>Last Name<span class="mandatory"> *</span></label>
    <input type="text" class="textfield" name="lastname" id="lastname" value="">
    <span></span>
  </div>

  <div class="form-group">
    <label>Email<span class="mandatory"> *</span></label>
    <input type="text" class="textfield" name="email" id="email" value="">
    <span></span>
  </div>

  <div class="form-group">
    <label>Address<span class="mandatory"> *</span></label>
    <input type="text" class="textfield" name="address" id="address" value="">
    <span></span>
  </div>
  <div class="discountDateClass">
      <ul>
        <li>
          <label>City<span class="mandatory"> *</span></label>
          <input type="text" class="textfield" name="city" id="city" value=""> 
        </li>
        <li>
          <label>Postal Code<span class="mandatory"> *</span></label>
          <input type="text" class="textfield" name="postal_code" id="postal_code" value="">
        </li>
      </ul>
  </div>
  <div class="discountDateClass">
      <ul>
        <li>
          <label>Country<span class="mandatory"> *</span></label>
          <input type="text" class="textfield" name="country" id="country" value="">
        </li>
      </ul>
  </div>
  
  <div class="form-row">
    <label for="card-element">
      Credit or debit card
    </label>
    <div id="card-element">
      <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display Element errors. -->
    <div id="card-errors" role="alert"></div>
  </div>

  <button value="add" name="add_client">Add Client</button>
</form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
  var stripe = Stripe('<?php echo $publishable_key?>');
  var elements = stripe.elements();
  // Custom styling can be passed to options when creating an Element.
  var style = {
    base: {
      color: '#32325d',
      lineHeight: '18px',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#aab7c4'
      }
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  };
  var ownerInfo;
  


  // Create an instance of the card Element.
  var card = elements.create('card', {style: style});

  // Add an instance of the card Element into the `card-element` <div>.
  card.mount('#card-element');

  card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Create a token or display an error when the form is submitted.
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    ownerInfo = {
      owner: {
        name: document.getElementById('firstname').value+document.getElementById('lastname').value,
        address: {
          line1: document.getElementById('address').value,
          city: document.getElementById('city').value,
          postal_code: document.getElementById('postal_code').value,
          country: document.getElementById('country').value,
        },
        email: document.getElementById('email').value
      },
    };

    stripe.createSource(card, ownerInfo).then(function(result) {
      if (result.error) {
        // Inform the user if there was an error
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } else {
        // Send the source to your server
        stripeSourceHandler(result.source);
      }
    });
  });


  function stripeSourceHandler(source) {
    // alert(source.id);
    // Insert the source ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeSource');
    hiddenInput.setAttribute('value', source.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
  }
</script>

<script type="text/javascript">
  $.validator.addMethod("specialName", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9_\- ]+$/.test(value);
    }, "Letters, numbers, hyphens and underscores are allowed");

  $.validator.addMethod('positiveNumber',
            function (value) {
                return Number(value) > 0;
            }, 'Please enter positive value');

  $('#payment-form').validate({
        rules: {
            firstname: {
                required : true,
                maxlength: 50,
                specialName: true
            },
            lastname: {
                required : true,
                maxlength: 50,
                specialName: true
            },
            email: {
                required: true,
                maxlength: 250,
                email: true
            },
            address: {
                required: true,
                maxlength: 255,
                specialName: true
            },
            city: {
                required: true,
                maxlength: 80,
                specialName: true  
            },
            postal_code: {
                required: true,
                maxlength: 15,
                specialName: true  
            },
            country: {
                required: true,
                maxlength: 80,
                specialName: true  
            },
        },
        messages: {
            firstname: {
                required: "Please enter First Name",
                maxlength: "Please enter not more than 50 characters"
            },
            lastname: {
                required: "Please enter Last Name",
                maxlength: "Please enter not more than 50 characters"
            },
            email: {
                required: "Please enter Email",
                maxlength: "Please enter not more than 250 characters"
            },
            address: {
                required: "Please enter Address",
                maxlength: "Please enter not more than 255 characters"
            },
            city: {
                required: "Please enter City",
                maxlength: "Please enter not more than 80 characters"  
            },
            postal_code: {
                required: "Please enter Postal Code",
                maxlength: "Please enter not more than 15 characters"  
            },
            country: {
                required: "Please enter Country",
                maxlength: "Please enter not more than 80 characters"  
            }
            
        }

    });

</script>

</div>
