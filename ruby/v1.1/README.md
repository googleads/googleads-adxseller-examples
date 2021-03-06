#DoubleClick Ad Exchange Seller REST API Ruby Samples

These samples demonstrate basic usage of the DoubleClick Ad Exchange Seller
REST API.

The DoubleClick Ad Exchange Seller API Client Libraries makes it easier to
write clients to programmatically access Ad Exchange Seller accounts.
The complete documentation for the DoubleClick Ad Exchange Seller API is
available from <https://developers.google.com/ad-exchange/seller-rest/>.

##Announcements and updates

For API and client library updates and news, please follow our Google+ Ads
Developers page: <https://plus.google.com/+GoogleAdsDevelopers/posts>
and our Google Ads Developers blog: <http://googleadsdeveloper.blogspot.com/>.

##Prerequisites
- [`Ruby 1.8.7+`](http://www.ruby-lang.org)

##Setup

###Download the repository contents

To download the contents of the repository, you can use the command

```
git clone https://github.com/googleads/googleads-adxseller-examples
```

or browse to <https://github.com/googleads/googleads-adxseller-examples> and
 download a zip.

###Authorization Setup
The API uses OAuth2 for security, you can read about the options for connecting
 at <https://developers.google.com/ad-exchange/seller-rest/getting_started#auth>

 * Launch the Google Developers Console <https://console.developers.google.com>
 * select a project
 * click **APIs & auth**
 * click the **Credentials** tab
 * if you need to create a ```Client ID for native application```
  * click **Create a new client ID**
  * select **Installed Application**
 * Click **Download JSON** for a ```Client ID for native application```
 * copy this file to ```ruby/v1.x/client_secrets.json```.

## Running the Examples

Execute the following commands:

```$ bundle install```

```$ bundle exec ruby get_all_ad_clients.rb```

Complete the authorization steps on your browser

Examine your shell output, be inspired and start hacking an amazing new app!
