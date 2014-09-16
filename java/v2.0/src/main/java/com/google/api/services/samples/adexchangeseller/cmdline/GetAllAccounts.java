/*
 * Copyright (c) 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */

package com.google.api.services.samples.adexchangeseller.cmdline;

import com.google.api.services.adexchangeseller.AdExchangeSeller;
import com.google.api.services.adexchangeseller.model.Account;
import com.google.api.services.adexchangeseller.model.Accounts;


/**
 *
 * This example gets all accounts for the logged in user.
 *
 * Tags: accounts.list
 *
 * @author api.Dean.Lukies@gmail.com (Dean Lukies)
 *
 */
public class GetAllAccounts {

  /**
   * Runs this sample.
   *
   * @param adExchangeSeller AdExchangeSeller service object on which to run the requests.
   * @param accountId the ID for the account to be used.
   * @param maxPageSize the maximum page size to retrieve.
   * @return the last page of retrieved accounts.
   * @throws Exception
   */
  public static Accounts run(AdExchangeSeller adExchangeSeller, int maxPageSize) throws Exception {
    System.out.println("=================================================================");
    System.out.println("Listing all AdExchangeSeller accounts");
    System.out.println("=================================================================");

    // Retrieve account list in pages and display data as we receive it.
    String pageToken = null;
    Accounts accounts = null;
    do {
      accounts = adExchangeSeller.accounts().list()
          .setMaxResults(maxPageSize)
          .setPageToken(pageToken)
          .execute();

      if (accounts.getItems() != null && !accounts.getItems().isEmpty()) {
        for (Account account : accounts.getItems()) {
          System.out.printf("Account with ID \"%s\" and name \"%s\" was found.%n",
              account.getId(), account.getName());
        }
      } else {
        System.out.println("No accounts found.");
      }

      pageToken = accounts.getNextPageToken();
    } while (pageToken != null);

    System.out.println();
    return accounts;
  }
}