<?php $this->start('head'); ?>

<style type="text/css">
</style>

<?php $this->end(); ?>

<?php 
use Core\FormHelpers;

 ?>

<?php $this->start('body'); ?>
<section id="shopping-cart" class="container">

  <h1 class="shopping-cart-header">Checkout</h1>

	<form action="<?= PROJECT_ROOT; ?>cart/checkout/<?= $this->cartId; ?>" method="post" id="payment-form">
	  <div class="form-group">
	     <?= FormHelpers::csrf_input(); ?>
	  </div>
	  <div class="form-group">
	    <label for="card-element">
	      Credit or debit card
	    </label>
	    <div id="card-element" class="form-control">
	      <!-- A Stripe Element will be inserted here. -->
	    </div>

	    <!-- Used to display Element errors. -->
	    <div id="card-errors" role="alert"></div>
	  </div>

	  <button>Submit Payment</button>
	</form>




</section>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" defer="">

	var stripe = Stripe('<?= STRIPE_PUBLIC; ?>');
	var elements = stripe.elements();

	// custom styling can be passed to options when creating an element.
	var style: {
      base: {
        color: "#32325D",
        fontWeight: 500,
        fontFamily: "Inter UI, Open Sans, Segoe UI, sans-serif",
        fontSize: "16px",
        fontSmoothing: "antialiased",

        "::placeholder": {
          color: "#CFD7DF"
        }
      },
      invalid: {
        color: "#E25950"
      }
  };

	// create an instance of the card element.
	var card = elements.create('card', {style: style});

	// add an instance of the card element into the `card-element` <div>.
	card.mount('#card-element');


	// Create a token or display an error when the form is submitted.
	var form = document.getElementById('payment-form');
	form.addEventListener('submit', function(event) {
	  event.preventDefault();

	  stripe.createToken(card).then(function(result) {
	    if (result.error) {
	      // Inform the customer that there was an error.
	      var errorElement = document.getElementById('card-errors');
	      errorElement.textContent = result.error.message;
	    } else {
	      // Send the token to your server.
	      stripeTokenHandler(result.token);
	    }
	  });
	});

	function stripeTokenHandler(token) {
	  // Insert the token ID into the form so it gets submitted to the server
	  var form = document.getElementById('payment-form');
	  var hiddenInput = document.createElement('input');
	  hiddenInput.setAttribute('type', 'hidden');
	  hiddenInput.setAttribute('name', 'stripeToken');
	  hiddenInput.setAttribute('value', token.id);
	  form.appendChild(hiddenInput);

	  // Submit the form
	  form.submit();
	}


	
</script>

<?php $this->end(); ?>
