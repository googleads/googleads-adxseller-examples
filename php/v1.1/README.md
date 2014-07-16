#DoubleClick Ad Exchange Seller REST API PHP Samples

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
- [`PHP 5.2.1+`](http://php.net/)
- [`PHP Client library for Google APIs`](https://developers.google.com/api-client-library/php/start/installation)

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
 * copy this file to ```php-clientlib-1.x /v1.x/client_secrets.json```.

## Running the Examples

Change the include path in ```adexchangeseller-sample.php``` to your client library installation

Open the sample (http://your/path/adexchangeseller-sample.php) in your browser

This will start an authentication flow, redirect back to your server, and then print data about your Ad Exchange Seller account.
