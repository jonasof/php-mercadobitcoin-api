<?php

namespace JonasOF\PHPMercadoBitcoinAPI\NonceMethods;

/** Neste caso informar current_nonce, obter o último em $nonce */
class Manual implements Method
{
    
    private $nonce;
    
    public function __construct($current_nonce)
    {
        $this->nonce = $current_nonce;
    }

    public function getCurrentNonce()
    {
        return $this->nonce;
    }
    
    public function incrementNonce()
    {
        $this->nonce++;
    }

}
