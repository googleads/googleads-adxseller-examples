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
 * Gets all metrics available for the specified account.
 *
 * Tags: metadata.metrics.list
 */
class GetAllMetrics {
  /**
   * Gets all metrics available for the specified account.
   *
   * @param $service Google_Service_AdExchangeSeller AdExchange Seller service
   *     object on which to run the requests.
   * @param $accountId string the ID for the account to be used.
   */
  public static function run($service, $accountId) {
    $separator = str_repeat('=', 80) . "\n";
    print $separator;
    print "Listing all metrics for specified account\n";
    print $separator;

    $result = $service->accounts_metadata_metrics->
        listAccountsMetadataMetrics($accountId);
    if (!empty($result['items'])) {
      $metrics = $result['items'];
      foreach ($metrics as $metric) {
        printf("Metric id \"%s\" for product(s): [%s] was found.\n",
            $metric['id'], join(', ', $metric['supportedProducts']));
      }
    } else {
      print "No metrics found.\n";
    }
    print "\n";
  }
}
