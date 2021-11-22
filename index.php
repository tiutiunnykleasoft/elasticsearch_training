<?php

use Elasticsearch\ClientBuilder;

require __DIR__ . "/vendor/autoload.php";

$host = [
    'localhost',
    'localhost:9200',
    '127.0.0.1',
    '0.0.0.0',
    '172.28.0.2'
];

$client = ClientBuilder::create()->setSSLVerification(false)->setHosts($host)->build();

if (isset($_POST)) {
    return $_POST;
}

$params = [
    'index' => 'car_repair',
    'type' => 'keys',
    'body' => [
        'title' => 'Duck key',
        'size' => 13
    ]
];

$result = $client->index($params);

$search1 = $client->search([
        'index' => 'car_repair',
        'type' => 'keys'
    ]
);
print_r($search1);
foreach ($search1['hits']['hits'] as $hit) {
    $client->delete([
        'id' => $hit['_id'],
        'index' => 'car_repair'
    ]);
}
