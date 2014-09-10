<?php

require '../vendor/autoload.php';

$app = new \Slim\Slim(array('mode' => 'development'));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
// This will add some verbosity to the application so that it will be easier to see potential mistakes
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => true
    ));
});

//Defines the HTTP GET route:
//this route matches the root folder so it will be hit when the user types http://URL/ or http://URL/index.php
$app->get('/', function () {

    require 'TopicData.php';

    $data = new TopicData();
    $data->connect();

    $topics = $data->getAllTopics();

    foreach ($topics as $topic) {
        echo "<h3>" .$topic['title']. " (ID: " .$topic['id']. ")</h3>";
        echo "<p>";
        echo nl2br($topic['description']);
        echo "</p>";
    }

});

//Run the Slim application:
$app->run();
