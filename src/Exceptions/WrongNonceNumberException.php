<?php

namespace JonasOF\PHPMercadoBitcoinAPI\Exceptions;

class WrongNonceNumberException extends \Exception
{
    public $nonce_atual;
    
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        
        $this->parseError($message);
    }
    
    public function parseError($error_message)
    {
        $matches = [];
        
        preg_match('/(?:\d*\.)?\d+/', $error_message, $matches);
        
        $this->nonce_atual = $matches[0];
    }
}
