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
 * This example gets all custom channels in an ad client.
 *
 * Tags: customchannels.list
 */
class GetAllCustomChannels {
  // Ad Exchange accounts are big, so for the purpose of this sample, we limit
  // the maximum number of pages we allow it to get.
  const MAX_PAGES = 2;

  /**
   * Gets all custom channels in an ad client.
   *
   * @param $service Google_Service_AdExchangeSeller AdExchange Seller service
   *     object on which to run the requests.
   * @param $adClientId string the ID for the ad client to be used.
   * @param $maxPageSize int the maximum page size to retrieve.
   * @return array the last page of retrieved custom channels.
   */
  public static function run($service, $adClientId, $maxPageSize) {
    $separator = str_repeat('=', 80) . "\n";
    print $separator;
    printf("Listing all custom channels for ad client %s\n", $adClientId);
    print $separator;

    $optParams['maxResults'] = $maxPageSize;

    $pageToken = null;
    $customChannels = null;
    $pageNumber = 0;
    do {
      if ($pageNumber == self::MAX_PAGES) {
        break;
      }
      $optParams['pageToken'] = $pageToken;
      $result = $service->customchannels->listCustomchannels($adClientId,
          $optParams);
      if (!empty($result['items'])) {
        $customChannels = $result['items'];
        foreach ($customChannels as $customChannel) {
          printf("Custom channel with code \"%s\" and name \"%s\" was found.\n",
              $customChannel['code'], $customChannel['name']);
        }
        if (isset($result['nextPageToken'])) {
          $pageToken = $result['nextPageToken'];
        }
      } else {
        print "No custom channels found.\n";
      }
      $pageNumber++;
    } while ($pageToken);
    print "\n";

    return $customChannels;
  }
}
