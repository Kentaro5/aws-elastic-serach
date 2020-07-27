<?php
require 'vendor/autoload.php';
use App\ElasticSearch;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$elastic_search = new ElasticSearch();

$elastic_search->update();
