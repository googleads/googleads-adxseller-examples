#!/usr/bin/env ruby
# Encoding: utf-8
#
# Author:: api.Dean.Lukies@gmail.com (Dean Lukies)
#
# Copyright:: Copyright 2014, Google Inc. All Rights Reserved.
#
# License:: Licensed under the Apache License, Version 2.0 (the "License");
#           you may not use this file except in compliance with the License.
#           You may obtain a copy of the License at
#
#           http://www.apache.org/licenses/LICENSE-2.0
#
#           Unless required by applicable law or agreed to in writing, software
#           distributed under the License is distributed on an "AS IS" BASIS,
#           WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
#           implied.
#           See the License for the specific language governing permissions and
#           limitations under the License.
#
# This example retrieves a report for the specified ad client.
#
# Please only use pagination if your application requires it due to memory or
# storage constraints.
# If you need to retrieve more than 5000 rows, please check generate_report.rb,
# as due to current limitations you will not be able to use paging for large
# reports.
# To get ad clients, run get_all_ad_clients.rb.
#
# Tags: reports.generate

require 'adexchangeseller_common'
require 'optparse'

# The maximum number of rows per page.
MAX_PAGE_SIZE = 50
# The maximum number of obtainable rows for paged reports. This is an API limit.
ROW_LIMIT = 5000

def generate_report_with_paging(adexchangeseller, options)
  start_index = 0
  rows_to_obtain = MAX_PAGE_SIZE
  ad_client_id = options[:ad_client_id]

  loop do
    result = adexchangeseller.accounts.reports.generate(
      :accountId => ACCOUNT_ID,
      :startDate => 'startOfMonth',
      :filter => ['AD_CLIENT_ID==' + ad_client_id],
      :endDate => 'today',
      :metric => ['PAGE_VIEWS', 'AD_REQUESTS', 'AD_REQUESTS_COVERAGE',
                  'CLICKS', 'AD_REQUESTS_CTR', 'COST_PER_CLICK',
                  'AD_REQUESTS_RPM', 'EARNINGS'],
      :dimension => ['DATE'],
      :sort => ['+DATE'],
      :startIndex => start_index,
      :maxResults => rows_to_obtain
    ).execute

    # If this is the first page, display the headers.
    if start_index == 0
      result.data.headers.each do |header|
        print '%25s' % header['name']
      end
      puts
    end

    # Display results.
    result.data.rows.each do |row|
      row.each do |column|
        print '%25s' % column
      end
      puts
    end

    start_index += result.data.rows.size

    # Check to see if we're going to go above the limit and get as many
    # results as we can.
    if start_index + MAX_PAGE_SIZE > ROW_LIMIT
      rows_to_obtain = ROW_LIMIT - start_index
      break if rows_to_obtain <= 0
    end

    break if start_index >= result.data.totalMatchedRows.to_i
  end
end


if __FILE__ == $0
  adexchangeseller = service_setup()

  options = {}

  optparse = OptionParser.new do |opts|
    opts.on('-c', '--ad_client_id AD_CLIENT_ID',
            'The ID of the ad client for which to generate a report') do |id|
      options[:ad_client_id] = id
    end
  end

  begin
    optparse.parse!
    unless options[:ad_client_id].nil? ^ options[:report_id].nil?
      raise OptionParser::MissingArgument
    end
  rescue OptionParser::MissingArgument
    puts 'Please specify an ad_client_id.'
    puts optparse
    exit
  end

  generate_report_with_paging(adexchangeseller, options)
end
