#DoubleClick Ad Exchange Seller REST API Python Samples

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
- [`Python 2`](https://www.python.org/download/)

##Setup

###Download the repository contents

To download the contents of the repository, you can use the command

```
git clone https://github.com/googleads/googleads-adxseller-examples
```

or browse to <https://github.com/googleads/googleads-adxseller-examples> and
 download a zip.

###Install Google API Python Client
Download and install the **Google API Python Client** with either
   easy_install or pip:

  * Using easy_install:

      ```
      $ easy_install --upgrade google-api-python-client
      ```

  * Using pip:

      ```
      $ pip install --upgrade google-api-python-client
      ```

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
 * copy this file to ```python/v1.x/client_secrets.json```.

##Running the examples
You should now be able to start any of the samples by running them from the
command line, for example:

```
$ python get_all_ad_clients.py
```
