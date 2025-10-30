<?php
require './vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51SNVuG22OYgfakmUeA5MDQml8ZKxIgZwoZbQ4BK4AbSC7X6gyCp5OVVngl3y3AOGHXqvgBBgRDvECawKUsQEaSx100EcVwzMlN');

header('Content-Type: application/json');

$paymentIntent = \Stripe\PaymentIntent::create([
  'amount' => 1099,
  'currency' => 'usd',
  'automatic_payment_methods' => ['enabled' => true],
]);

echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
