# The Odds API Code Samples (v4) - PHP

The Odds API provides live odds for loads of sports from bookmakers around the world, in an easy to use JSON format.

Before getting started, be sure to get a free API key from [https://the-odds-api.com](https://the-odds-api.com)

For more info on the API, [see the docs](https://the-odds-api.com/liveapi/guides/v4/)


## Get Started

```
php sample-v4.php YOUR_API_KEY
```

This will print:
- A list of in-season sports
- Events and odds for the next 8 upcoming games (across all sports)
- Requests used & remaining for your api key

To change the sport, region and market, see the parameters specified at the beginning of sample-v4.php

Make sure the guzzle is installed in order to make http requests `composer require guzzlehttp/guzzle`


---


## Using Docker (Mac and Linux)

Build the image

```
docker build -t theoddsapi/sample:latest .
```

Run the php script in the container

```
docker run -t -i --rm -v "$(pwd)":/usr/src/app/ theoddsapi/sample:latest php sample-v4.php YOUR_API_KEY
```

