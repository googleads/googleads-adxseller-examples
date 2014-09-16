<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * A sample application that runs a request against the DoubleClick
 * Ad Exchange Seller REST API.
 *
 */

require_once 'templates/base.php';
session_start();

/************************************************
  ATTENTION: Change this path to point to your
  client library installation!
 ************************************************/
set_include_path('/path/to/clientlib' . PATH_SEPARATOR . get_include_path());

require_once 'Google/Client.php';
require_once 'Google/Service/AdExchangeSeller.php';

// Set up authentication.
$client = new Google_Client();

// Be sure to replace the contents of client_secrets.json with your developer
// credentials.
$client->setAuthConfigFile('client_secrets.json');
$client->addScope('https://www.googleapis.com/auth/adexchange.seller');

// Create service.
$service = new Google_Service_AdExchangeSeller($client);

// If we're logging out we just need to clear our local access token
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

// If we have a code back from the OAuth 2.0 flow, we need to exchange that
// with the authenticate() function. We store the resultant access token
// bundle in the session, and redirect to this page.
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  exit;
}

// If we have an access token, we can make requests, else we generate an
// authentication URL.
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

echo pageHeader('Ad Exchange Seller REST API - First API Request');

echo '<div><div class="request">';
if (isset($authUrl)) {
  echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
} else {
  echo '<a class="logout" href="?logout">Logout</a>';
};
echo '</div>';

if ($client->getAccessToken()) {
  echo '<pre class="result">';
  print "\n";
  // Set up a report
  $startDate = 'today-6d';
  $endDate = 'today';

  // Set metrics, dimensions and sort order
  $optParams = array(
      'metric' => array('AD_REQUESTS', 'CLICKS'),
      'dimension' => array('DATE', 'WINNING_BID_RULE_NAME'),
      'sort' => '+DATE'
  );

  // Run report.
  // If this was a bigger report we would use paging, see
  // GenerateReportWithPaging.php for more information.
  $report = $service->accounts_reports->generate("myaccount", $startDate,
        $endDate, $optParams);

  // Display the returned data.
  if (isset($report) && isset($report['rows'])) {
    // Display headers.
    foreach($report['headers'] as $header) {
      printf('%25s', $header['name']);
    }
    print "\n";

    // Display results.
    foreach($report['rows'] as $row) {
      foreach($row as $column) {
        printf('%25s', $column);
      }
      print "\n";
    }

    // Display totals
    foreach($report['totals'] as $total) {
      printf('%25s', $total);
    }
    print "\n";
  } else {
    print "No rows returned.\n";
  }

  print "\n";
  // Note that we re-store the access_token bundle, just in case anything
  // changed during the request - the main thing that might happen here is the
  // access token itself is refreshed if the application has offline access.
  $_SESSION['access_token'] = $client->getAccessToken();
  echo '</pre>';
}

echo '</div>';
echo pageFooter(__FILE__);
