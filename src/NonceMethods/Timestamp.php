<?php 

namespace JonasOF\PHPMercadoBitcoinAPI\NonceMethods;

/** Caso você queira basear o número no timestamp atual */
class Timestamp implements Method
{
    
    public function getCurrentNonce()
    {
        return time();
    }
    
    public function incrementNonce()
    {
        
    }

}
