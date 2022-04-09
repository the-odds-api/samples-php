<?php

require 'vendor/autoload.php';

use \GuzzleHttp\Client;

# An api key is emailed to you when you sign up to a plan
# Get a free API key at https:#api.the-odds-api.com/
$apiKey = $argv[1] ?? 'YOUR_API_KEY';

$sport = 'upcoming'; # use the sport_key from the /sports endpoint below, or use 'upcoming' to see the next 8 games across all sports

$regions = 'us'; # uk | us | eu | au. Multiple can be specified if comma delimited

$markets = 'h2h,spreads'; # h2h | spreads | totals. Multiple can be specified if comma delimited

$oddsFormat = 'decimal'; # decimal | american

$dateFormat = 'iso'; # iso | unix

$client = new Client();

# First get a list of in-season sports
#   The sport 'key' from the response can be used to get odds in the next request
$sportsResponse = $client->request('GET', 'https://api.the-odds-api.com/v4/sports', [
    'query' => ['api_key' => $apiKey],
    'http_errors' => false,
]);

if ($sportsResponse->getStatusCode() !== 200) {
    echo PHP_EOL;
    echo "Failed to get sports: status_code {$sportsResponse->getStatusCode()}, response body {$sportsResponse->getBody()}";
    echo PHP_EOL;
} else {
    echo "List of in season sports: {$sportsResponse->getBody()}";
    echo PHP_EOL;
}


# Now get a list of live & upcoming games for the sport you want, along with odds for different bookmakers
# This will deduct from the usage quota
# The usage quota cost = [number of markets specified] x [number of regions specified]
# For examples of usage quota costs, see https:#the-odds-api.com/liveapi/guides/v4/#usage-quota-costs

$oddsResponse = $client->request('GET', "https://api.the-odds-api.com/v4/sports/$sport/odds", [
    'query' => [
        'api_key' => $apiKey,
        'regions' => $regions,
        'markets' => $markets,
        'oddsFormat' => $oddsFormat,
        'dateFormat' => $dateFormat,
    ],
    'http_errors' => false,
]);

if ($oddsResponse->getStatusCode() !== 200) {
    echo PHP_EOL;
    echo "Failed to get odds: status_code {$oddsResponse->getStatusCode()}, response body {$oddsResponse->getBody()}";
    echo PHP_EOL;
} else {

    $oddsJson = json_decode($oddsResponse->getBody());
    echo PHP_EOL;
    echo "Number of events: " . count( $oddsJson );
    echo PHP_EOL;
    echo $oddsResponse->getBody();
    echo PHP_EOL;

    # Check the usage quota
    echo PHP_EOL;
    echo "Remaining requests: " . $oddsResponse->getHeader('x-requests-remaining')[0];
    echo PHP_EOL;
    echo "Used requests: " . $oddsResponse->getHeader('x-requests-used')[0];
    echo PHP_EOL;
}