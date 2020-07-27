<?php
namespace App;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

/**
*
*/
class ElasticSearch
{
    private $elastic_host;
    private $elastic_hosts;

    public function __construct()
    {
        $this->elastic_host = $_ENV['MY_OWN_URL'];
        $this->elastic_hosts = [ $_ENV['MY_OWN_URL'] ];
    }

    /**
    * @var $this->elastic_host
    **/
    public function createHost():Client
    {
        return ClientBuilder::create()
        ->setSSLVerification(false)
        ->setHosts([$this->elastic_host])->build();
    }

    /**
    * Index a document
    **/
    public function index():Void
    {
        $client = $this->createHost();

        $indexParams = [
           'index' => 'new_index',
           'type' => 'new_type',
           'id' => '1',
           'body' => [
                'Description' =>'ZZZZZ'
            ]
        ];

        $response = '';
        try {
            $response = $client->index($indexParams);
            echo "<pre>";
            echo "**********************";
            print_r($response);
            echo "**********************";
            var_dump();
            echo "**********************";
            echo "</pre>";
        } catch (Exception $e) {
            echo "Exception : ".$e->getMessage();
        }
    }

    /**
    * Get a document
    **/
    public function get():Void
    {
        $client = $this->createHost();

        $params = [
            'index' => 'new_index',
            'type' => 'new_type',
            'id' => '1'
        ];

        $response = $client->get($params);
        echo "<pre>";
        echo "**********************";
        print_r($response);
        echo "**********************";
        var_dump();
        echo "**********************";
        echo "</pre>";
    }
}
