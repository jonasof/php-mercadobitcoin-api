<?php

use JonasOF\PHPMercadoBitcoinAPI\PHPMercadoBitcoinAPI;
use JonasOF\PHPMercadoBitcoinAPI\NonceMethods\Manual;

class MercadoBitcoinTest extends PHPUnit_Framework_TestCase
{
    public $app;
    public $mock;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->app = new PHPMercadoBitcoinAPI([
            'TAPI_PASSWORD' => 'testing',
            'TAPI_ID' => 'testing'
        ], new Manual(1));
    }
    
    public function testGetAccountInfo()
    {
        $json = '{"response_data": {"balance": {"brl": {"available": "10.0", "total": "20.0"}, "btc": {"available": "0.05", "total": "0.05", "amount_open_orders": 0}, "ltc": {"available": "0.00000000", "total": "0.00000000", "amount_open_orders": 0}}, "withdrawal_limits": {"brl": {"available": "20000.00", "total": "20000.00"}, "btc": {"available": "25.00000000", "total": "25.00000000"}, "ltc": {"available": "500.00000000", "total": "500.00000000"}}}, "status_code": 100, "server_unix_timestamp": "140000000"}';
     
        $this->setMockResponse($json);
        
        $result = $this->app->getAccountInfo();
        $this->assertJsonStringEqualsJsonString(json_encode($result), $json);
    }
    
    public function setMockResponse($body)
    {
        
        $mock = new GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], $body),
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $this->app->guzzle = new GuzzleHttp\Client(['handler' => $handler]);
        
    }
    
}
