<?php

namespace JonasOF\PHPMercadoBitcoinAPI;

/**
 * Ver descrição dos métodos em https://www.mercadobitcoin.com.br/trade-api/
 */
class PHPMercadoBitcoinAPI
{
    private $options;
    
    private $base_url = "https://www.mercadobitcoin.net/tapi/v3/";
    private $base_uri = "/tapi/v3/";
    
    /**
     *
     * @var \GuzzleHttp\Client $guzzle
     */
    public $guzzle;
    
    const COIN_PAIR_BRLBTC = "BRLBTC";
    const COIN_PAIR_BRLLTC = "BRLLTC";
    
    const COIN_BRL = "BRL";
    const COIN_BTC = "BTC";
    const COIN_LTC = "LTC";
        
    public $nonce_method;
    
    /**
     * @param array $options
     * @param NonceMethods\Method $nonce_method
     * @throws Exceptions\MissingParamException
     */
    public function __construct($options, NonceMethods\Method $nonce_method)
    {
        $this->options = $options;
        $this->guzzle = new \GuzzleHttp\Client();
        $this->nonce_method = $nonce_method;
        
        if (!isset($this->options['TAPI_PASSWORD'])) {
            throw new Exceptions\MissingParamException("Missing TAPI_PASSWORD");
        }
        
        if (!isset($this->options['TAPI_ID'])) {
            throw new Exceptions\MissingParamException("Missing TAPI_ID");
        }
    }
    
    /**
     * @return stdObject
     */
    public function getAccountInfo()
    {
        return $this->doRequest('get_account_info', []);
    }
  
    /**
     * @param array $params chaves: order_id, coin_pair
     * @return stdObject
     */
    public function getOrder($params)
    {
        return $this->doRequest('get_account_info', $params);
    }
    
    /**
     *
     * @param array $params contendo coin_pair (opcionais: order_type,
     * status_list, has_fills, from_id, to_id, from_timestamp, to_timestamp)
     * @return stdObject
     */
    public function listOrders($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin_pair, opcionais: full
     * @return stdObject
     */
    public function listOrderbook($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin_pair, quantity, limit_price
     * @return stdObject
     */
    public function placeBuyOrder($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin_pair, full, limit_price
     * @return stdObject
     */
    public function placeSellOrder($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin_pair, $order_id
     * @return stdObject
     */
    public function cancelOrder($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin, withdrawal_id
     * @return stdObject
     */
    public function getWithdrawal($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * @param array $params coin, quantity, destinity, opcionais: description
     * @return stdObject
     */
    public function withdrawCoin($params)
    {
        return $this->doRequest('list_orders', $params);
    }
    
    /**
     * Precisamos gerar o "TAPI-MAC" com base numa "query-string":
     * /tapi/v3/?tapi_method=list_orders&tapi_nonce=1
     *
     */
    protected function doRequest($method, $params = [])
    {
        $form_params = [
            'tapi_method' => $method,
            'tapi_nonce' => $this->nonce_method->getCurrentNonce(),
        ];
        
        $this->nonce_method->incrementNonce();
        
        $form_params = array_merge($form_params, $params);
        
        $mac_brute = $this->base_uri . '?' . http_build_query($form_params);
        $mac = hash_hmac('sha512', $mac_brute, $this->options['TAPI_PASSWORD']);
        
        $resquest = $this->guzzle->request('post', $this->base_url, [
            'form_params' => $form_params,
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
                'TAPI-ID' => $this->options['TAPI_ID'],
                'TAPI-MAC' => $mac
            ],
        ]);
        
        $response = json_decode($resquest->getBody());
        if (isset($response->error_message) && strpos($response->error_message, 'tapi_nonce'))
        {
            throw new Exceptions\WrongNonceNumberException($response->error_message);
        }
        
        return $response;
    }
    
}
