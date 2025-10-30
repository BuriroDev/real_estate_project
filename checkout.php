<?php include "./header.php"; ?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Stripe Test</title>
  <script src="https://js.stripe.com/v3/"></script>
</head>

<body style="margin-top: 200px;">
  <div class="container mb-5">
    <h2>Pay to Buy</h2>
    <div id="payment-message"></div>

    <form id="payment-form">
      <div id="payment-element"></div>
      <button id="submit" class="btn btn-primary mt-2">Pay</button>
    </form>
  </div>

  <script>
    const stripe = Stripe("pk_test_51SNVuG22OYgfakmUoKzlo8XLkfw8M3EOVrFEDfihGlZ7IU76OcJhgXAZFXf1MIy6PrrEunRxwli7vHnMJW5SsFM90077XeRIah");

    async function init() {
      const resp = await fetch("create_payment_intent.php", {
        method: "POST"
      });
      const data = await resp.json();

      if (!data.clientSecret) {
        document.getElementById("payment-message").textContent = "Failed to load PaymentIntent.";
        return;
      }

      const elements = stripe.elements({
        clientSecret: data.clientSecret
      });
      const paymentElement = elements.create("payment");
      paymentElement.mount("#payment-element");

      const form = document.getElementById("payment-form");
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const {
          error
        } = await stripe.confirmPayment({
          elements,
          confirmParams: {
            return_url: window.location.href = "home.php?paid=true"
          }
        });
        if (error) document.getElementById("payment-message").textContent = error.message;
      });
    }
    init();
  </script>
</body>

</html>

<?php include "./footer.php"; ?>