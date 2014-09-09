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

import com.google.api.client.auth.oauth2.Credential;
import com.google.api.client.extensions.java6.auth.oauth2.AuthorizationCodeInstalledApp;
import com.google.api.client.extensions.jetty.auth.oauth2.LocalServerReceiver;
import com.google.api.client.googleapis.auth.oauth2.GoogleAuthorizationCodeFlow;
import com.google.api.client.googleapis.auth.oauth2.GoogleClientSecrets;
import com.google.api.client.googleapis.javanet.GoogleNetHttpTransport;
import com.google.api.client.http.HttpTransport;
import com.google.api.client.json.JsonFactory;
import com.google.api.client.json.jackson2.JacksonFactory;
import com.google.api.client.util.store.FileDataStoreFactory;
import com.google.api.services.adexchangeseller.AdExchangeSeller;
import com.google.api.services.adexchangeseller.AdExchangeSeller.Reports.Generate;
import com.google.api.services.adexchangeseller.AdExchangeSellerScopes;
import com.google.api.services.adexchangeseller.model.Report;

import java.io.InputStreamReader;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;

/**
 * A sample application that authenticates and runs a request against the Ad Exchange.
 */
public class FirstApiRequest {
  /**
   * Be sure to specify the name of your application. If the application name is {@code null} or
   * blank, the application will log a warning. Suggested format is "MyCompany-ProductName/1.0".
   */
  private static final String APPLICATION_NAME = "";

  /** Directory to store user credentials. */
  private static final java.io.File DATA_STORE_DIR =
      new java.io.File(System.getProperty("user.home"), ".store/adexchangeseller_sample");

  /**
   * Global instance of the DataStoreFactory. The best practice is to make it a
   * single globally shared instance across your application.
   */
  private static FileDataStoreFactory dataStoreFactory;

  /** Global instance of the JSON factory. */
  private static final JsonFactory jsonFactory
    = JacksonFactory.getDefaultInstance();

  /** Global instance of the HTTP transport. */
  private static HttpTransport httpTransport;

  public static void main(String[] args) throws Exception {
    httpTransport = GoogleNetHttpTransport.newTrustedTransport();
    dataStoreFactory = new FileDataStoreFactory(DATA_STORE_DIR);

    GoogleClientSecrets clientSecrets = GoogleClientSecrets.load(
        jsonFactory, new InputStreamReader(
            FirstApiRequest.class.getResourceAsStream("/client_secrets.json")));
    if (clientSecrets.getDetails().getClientId().startsWith("Enter")
        || clientSecrets.getDetails().getClientSecret().startsWith("Enter ")) {
      System.out.println("Enter Client ID and Secret from "
          + "https://code.google.com/apis/console/?api=adexchangeseller into "
          + "adexchangeseller-cmdline-sample/src/main/resources/client_secrets.json");
      System.exit(1);
    }
    // set up authorization code flow
    GoogleAuthorizationCodeFlow flow = new GoogleAuthorizationCodeFlow.Builder(
        httpTransport, jsonFactory, clientSecrets,
        Collections.singleton(AdExchangeSellerScopes.ADEXCHANGE_SELLER_READONLY))
        .setDataStoreFactory(dataStoreFactory).build();
    // authorize and get credentials
    Credential credential =
        new AuthorizationCodeInstalledApp(flow, new LocalServerReceiver())
          .authorize("user");

    // Create an authorized AdExchangeSeller instance
    AdExchangeSeller adExchangeSeller = new AdExchangeSeller.Builder(httpTransport,
        jsonFactory, credential).setApplicationName(APPLICATION_NAME).build();

    // Set up a report object for the last 7 days’ performance
    Generate request = adExchangeSeller.reports().generate("today-6d", "today");

    // Add report dimensions
    request.setDimension(Arrays.asList("DATE", "WINNING_BID_RULE_NAME"));
    // Add report metrics
    request.setMetric(Arrays.asList("AD_REQUESTS", "CLICKS"));

    // Run the report.
    // If this was a bigger report we would use paging, see GenerateReportWithPaging.java
    Report response = request.execute();

    if (response.getRows() == null || response.getRows().isEmpty()) {
      System.out.println("No rows returned.");
      return;
    }

    // Display the returned data
    displayHeaders(response.getHeaders());
    displayRows(response.getRows());
    displayTotals(response.getTotals());
  }

  /**
   * Displays the headers for the report.
   */
  private static void displayHeaders(List<Report.Headers> headers) {
    for (Report.Headers header : headers) {
      System.out.printf("%25s", header.getName());
    }
    System.out.println();
  }

  /**
   * Displays a list of rows for the report.
   */
  public static void displayRows(List<List<String>> rows) {
    // Display results.
    for (List<String> row : rows) {
      for (String column : row) {
        System.out.printf("%25s", column);
      }
      System.out.println();
    }
  }

  /**
   * Displays the totals list for the report.
   */
  public static void displayTotals(List<String> totals) {
    // Display totals.
    for (String column : totals) {
      System.out.printf("%25s", column);
    }
  }
}
