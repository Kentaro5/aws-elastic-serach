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

    /**
    * Search a document
    * 参考にしたやつ：https://qiita.com/NAO_MK2/items/630f2c4caa0e8a42407c
    **/
    public function search():Void
    {
        $client = $this->createHost();

        $params = [
            'index' => 'new_index',
            'type' => 'new_type',
            'body' => [
                "query"=> [
                    'wildcard' => [
                        'Description' => '*Z*',
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        echo "<pre>";
        echo "**********************";
        print_r($response);
        echo "**********************";
        var_dump();
        echo "**********************";
        echo "</pre>";
    }

    /**
    * Update a document
    **/
    public function update():Void
    {
        $client = $this->createHost();

        $params = [
            'index' => 'new_index',
            'type' => 'new_type',
            'id' => '1',
            'body' => [
                'doc' => [
                    'Description' =>'test'
                ]
            ]
        ];


        $response = $client->update($params);
        echo "<pre>";
        echo "**********************";
        print_r($response);
        echo "**********************";
        var_dump();
        echo "**********************";
        echo "</pre>";
    }

    /**
    * show all document
    **/
    public function showAllData():Void
    {
        $client = $this->createHost();

        $params = [
            
            'body' => [
                "size" => 20,
                "query"=> [
                    "match_all"=> new class {
                    }
                ]
            ]
        ];

        $response = $client->search($params);
        echo "<pre>";
        echo "**********************";
        print_r($response);
        echo "**********************";
        var_dump();
        echo "**********************";
        echo "</pre>";
    }

    /**
    * Use Bulk Index method
    *@url https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html
    * 複数の処理をまとめて一つのリクエストで要求できるAPI
    * このAPIを利用することで一つずつリクエストする場合に比べ、処理速度を大幅に稼ぐことができる
    **/
    public function bulkIndex():Void
    {
        $client = $this->createHost();

        for ($i = 0; $i < 100; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'my_index'.$i,
                ]
            ];

            $params['body'][] = [
                'my_field'     => 'my_value'.$i,
                'second_field' => 'some more values'.$i
            ];
        }

        $responses = $client->bulk($params);

        echo "<pre>";
        echo "**********************";
        print_r($response);
        echo "**********************";
        var_dump();
        echo "**********************";
        echo "</pre>";
    }
}
