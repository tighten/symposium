## Google API Key Guide

### Create a Key

1. Create an API Key from the [Google Places API Documentation](https://developers.google.com/places/web-service/get-api-key) by clicking on the "GET A KEY" button.

![Generate API Key](https://www.dropbox.com/s/08jv8ngi8nm9r6x/google_key.gif?raw=1)

1. Once you have a key, save it to your .env file using the environment key `GOOGLE_MAPS_API_KEY`.
1. Next, click on the `API Console` link just below the API Key. This will take you to your API Console where you can enable/disable APIs and manage credentials.

> It is highly recommended to restrict your API Key, especially in production.

### Enable Javascript API

1. Click on Library
1. Click on the Google Maps Javascript API
1. Click on Enable

![Enable Javascript API](https://www.dropbox.com/s/mitnsosb976pab2/enable_api_cropped.gif?raw=1)

You're now ready to start using the API Key in your application!
