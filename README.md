# PHP MercadoBitcoin API

Este é um cliente PHP não oficial para api mercadobitcoin.com.br.

## Como usar?

Instale usando composer: 

```
composer require jonasof/php-mercadobitcoin-api
```

Crie sua conta e siga os passos em https://www.mercadobitcoin.com.br/trade-api/

Exemplo:

```php
$nonce_method = new JonasOF\PHPMercadoBitcoinAPI\NonceMethods\Timestamp()
$api = new JonasOF\PHPMercadoBitcoinAPI\PHPMercadoBitcoinAPI([
    "TAPI_ID" => "seu_identificador_32_Caracteres",
    "TAPI_PASSWORD" => 'seu_segredo',
], $nonce_method);
$api->getAccountInfo();
```

Todos os métodos estão disponíveis para uso, porém nem todos foram testados:

 * getAccountInfo() - testado
 * getOrder($params)
 * listOrders($params)
 * listOrderbook($params)
 * placeBuyOrder($params)
 * placeSellOrder($params)
 * cancelOrder($params)
 * getWithdrawal($params)
 * withdrawCoin($params)

Há três métodos para atender o nonce especificado no manual:

 * Manual: informe no construtor o nonce atual (último usado + 1)
 * File (recomendado): crie um arquivo e insira no mesmo o nonce atual (último + 1)
 * Timestamp: gera um nonce através através do timestamp atual - não atende 
    mais que uma requisição por segundo.

## Requerimentos

PHP >= 5.5

## SEM GARANTIAS - NÃO OFICIAL

Não há nenhuma garantia de funcionamento. Se possível leia e teste o código 
antes de usá-lo.

Contribuições são bem vindas.
