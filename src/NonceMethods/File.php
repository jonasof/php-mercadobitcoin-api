<?php

namespace JonasOF\PHPMercadoBitcoinAPI\NonceMethods;


/** Neste caso informar nos parâmetros nonce_store_url */
class File implements Method
{
    
    private $nonce;
    
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
        $this->nonce = (int) file_get_contents($file_path);
        if ($this->nonce <= 0)
            throw new \Exception("");
    }

    public function getCurrentNonce()
    {
        return $this->nonce;
    }
    
    public function incrementNonce()
    {
        $this->nonce++;
        file_put_contents($this->file_path, $this->nonce);
    }

}
