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
# This example gets all URL channels in an ad client.
#
# To get ad clients, run get_all_ad_clients.rb.
#
# Tags: urlchannels.list

require 'adexchangeseller_common'
require 'optparse'

# The maximum number of results to be returned in a page.
MAX_PAGE_SIZE = 50

def get_all_url_channels(adexchangeseller, options)
  request = adexchangeseller.accounts.urlchannels.list(
      :accountId => ACCOUNT_ID,
      :adClientId => options[:ad_client_id],
      :maxResults => MAX_PAGE_SIZE)

  loop do
    result = request.execute

    result.data.items.each do |url_channel|
      puts 'URL channel with URL pattern "%s" was found.' %
        url_channel.urlPattern
    end

    break unless result.next_page_token
    request = result.next_page
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

  get_all_url_channels(adexchangeseller, options)
end
