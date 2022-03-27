<?php

require 'vendor/autoload.php';
// This is your real test secret API key.
\Stripe\Stripe::setApiKey('sk_test_51Ki3ZLFocG26TLDnWgRgqpiVsEOzvlL1dRc8gGOrc99O83eYUbS6iFvbx3ErZD7LNM9yzEXTeSPphoIxDF527yqv00eyvb5iTr');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242/public/success.html';

try {
  $checkout_session = \Stripe\Checkout\Session::retrieve($_POST['session_id']);
  $return_url = $YOUR_DOMAIN;

  // Authenticate your user.
  $session = \Stripe\BillingPortal\Session::create([
    'customer' => $checkout_session->customer,
    'return_url' => $return_url,
  ]);
  header("HTTP/1.1 303 See Other");
  header("Location: " . $session->url);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}