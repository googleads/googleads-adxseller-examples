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
 * A sample application that runs multiple requests against the DoubleClick
 * Ad Exchange Seller REST API. These include:
 * <ul>
 * <li>Listing all ad clients for an account</li>
 * <li>Listing all ad units for an ad client</li>
 * <li>Listing all custom channels for an ad unit</li>
 * <li>Listing all custom channels for an ad client</li>
 * <li>Listing all ad units for a custom channel</li>
 * <li>Listing all URL channels for an ad client</li>
 * <li>Running a report for an ad client, for the past 7 days</li>
 * <li>Running a paginated report for an ad client, for the past 7 days</li>
 * <li>Listing all saved reports for an account</li>
 * <li>Running a saved report for an account</li>
 * <li>Listing all alerts for an account</li>
 * <li>Listing all dimensions for the user</li>
 * <li>Listing all metrics for the user</li>
 * </ul>
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

// Autoload example classes.
function __autoload($class_name) {
  include 'examples/' . $class_name . '.php';
}

// Max results per page.
define('MAX_LIST_PAGE_SIZE', 50, true);
define('MAX_REPORT_PAGE_SIZE', 50, true);

// Set up authentication.
$client = new Google_Client();
$client->addScope('https://www.googleapis.com/auth/adexchange.seller');
$client->setAccessType('offline');

// Be sure to replace the contents of client_secrets.json with your developer
// credentials.
$client->setAuthConfigFile('client_secrets.json');

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

echo pageHeader('Ad Exchange Seller REST API sample');

echo '<div><div class="request">';
if (isset($authUrl)) {
  echo '<a class="login" href="' . $authUrl . '">Connect Me!</a>';
} else {
  echo '<a class="logout" href="?logout">Logout</a>';
};
echo '</div>';

if ($client->getAccessToken()) {
  echo '<pre class="result">';
  // Now we're signed in, we can make our requests.
  makeRequests($service);
  // Note that we re-store the access_token bundle, just in case anything
  // changed during the request - the main thing that might happen here is the
  // access token itself is refreshed if the application has offline access.
  $_SESSION['access_token'] = $client->getAccessToken();
  echo '</pre>';
}

echo '</div>';
echo pageFooter(__FILE__);


// Makes all the API requests.
function makeRequests($service) {
  print "\n";

  $adClients = GetAllAdClients::run($service, MAX_LIST_PAGE_SIZE);
  echo pageFooter(__FILE__);

  if (!empty($adClients)) {
    // Get an ad client ID, so we can run the rest of the samples.
    $exampleAdClient = end($adClients);
    $exampleAdClientId = $exampleAdClient['id'];

    $adUnits = GetAllAdUnits::run($service, $exampleAdClientId,
        MAX_LIST_PAGE_SIZE);
    if (!empty($adUnits)) {
      // Get an example ad unit ID, so we can run the following sample.
      $exampleAdUnitId = $adUnits[0]['id'];
      GetAllCustomChannelsForAdUnit::run($service, $exampleAdClientId,
          $exampleAdUnitId, MAX_LIST_PAGE_SIZE);
    } else {
      print 'No ad units found, unable to run dependant example.';
    }

    $customChannels = GetAllCustomChannels::run($service, $exampleAdClientId,
        MAX_LIST_PAGE_SIZE);
    if (!empty($customChannels)) {
      // Get an example ad unit ID, so we can run the following sample.
      $exampleCustomChannelId = $customChannels[0]['id'];
      GetAllAdUnitsForCustomChannel::run($service, $exampleAdClientId,
          $exampleCustomChannelId, MAX_LIST_PAGE_SIZE);
    } else {
      print 'No custom channels found, unable to run dependant example.';
    }

    GetAllUrlChannels::run($service, $exampleAdClientId, MAX_LIST_PAGE_SIZE);
    GenerateReport::run($service, $exampleAdClientId);
    GenerateReportWithPaging::run($service, $exampleAdClientId,
        MAX_REPORT_PAGE_SIZE);
  } else {
    print 'No ad clients found, unable to run dependant examples.';
  }

  $savedReports = GetAllSavedReports::run($service, MAX_LIST_PAGE_SIZE);
  if (!empty($savedReports)) {
    // Get an example saved report ID, so we can run the following sample.
    $exampleSavedReportId = $savedReports[0]['id'];
    GenerateSavedReport::run($service, $exampleSavedReportId);
  } else {
    print 'No saved reports found, unable to run dependant example.';
  }

  GetAllAlerts::run($service);
  GetAllDimensions::run($service);
  GetAllMetrics::run($service);
}
