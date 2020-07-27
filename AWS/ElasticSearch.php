<?php
namespace App;

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

}