#DoubleClick Ad Exchange Seller REST API Java Samples

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
- [`Java 6+`](http://java.com)
- [`Maven`](http://maven.apache.org)

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
 * copy this file to src/main/resources/client_secrets.json.

## Running the Examples
### Via the command line ###

1. Execute the following commands:

    ```
    $ mvn compile
    ```

    ```
    $ mvn -q exec:java
    ```

### Via Eclipse ###

1. Setup Eclipse preferences:
    1. Window > Preferences .. (or on Mac, Eclipse > Preferences)
    2. Select Maven
    3. Select "Download Artifact Sources"
    4. Select "Download Artifact JavaDoc"
2. Import the sample project
    1. File > Import...
    2. Select General > Existing Project into Workspace and click "Next"
    3. Click "Browse" next to "Select root directory", find the sample directory
    and click "Next"
    4. Click "Finish"
3. Right-click on the project and select Run As > Java
    Application

**Note:** To enable logging of HTTP requests and responses (highly recommended
when developing), please take a look at [logging.properties](logging.properties).
