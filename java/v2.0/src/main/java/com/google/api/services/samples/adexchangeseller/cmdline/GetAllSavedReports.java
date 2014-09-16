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
import com.google.api.services.adexchangeseller.model.SavedReport;
import com.google.api.services.adexchangeseller.model.SavedReports;

/**
 *
 * This example gets all saved reports for the logged in user's account.
 *
 * Tags: reports.saved.list
 *
 * @author api.Dean.Lukies@gmail.com (Dean Lukies)
 *
 */
public class GetAllSavedReports {

  /**
   * Runs this sample.
   *
   * @param adExchangeSeller AdExchangeSeller service object on which to run the requests.
   * @param accountId the ID for the account to be used.
   * @param maxPageSize the maximum page size to retrieve.
   * @return the last page of saved reports.
   * @throws Exception
   */
  public static SavedReports run(AdExchangeSeller adExchangeSeller,
      String accountId, int maxPageSize) throws Exception {
    System.out.println("=================================================================");
    System.out.printf("Listing all saved reports for the specified account%n");
    System.out.println("=================================================================");

    // Retrieve saved report list in pages and display the data as we receive it.
    String pageToken = null;
    SavedReports savedReports = null;
    do {
      savedReports = adExchangeSeller.accounts().reports()
          .saved()
          .list(accountId)
          .setMaxResults(maxPageSize)
          .setPageToken(pageToken)
          .execute();

      if (savedReports.getItems() != null && !savedReports.getItems().isEmpty()) {
        for (SavedReport savedReport : savedReports.getItems()) {
          System.out.printf("Saved report with id \"%s\" and name \"%s\" was found.%n",
              savedReport.getId(), savedReport.getName());
        }
      } else {
        System.out.println("No saved reports found.");
      }

      pageToken = savedReports.getNextPageToken();
    } while (pageToken != null);

    System.out.println();
    return savedReports;
  }
}
