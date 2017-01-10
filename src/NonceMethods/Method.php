<?php

namespace JonasOF\PHPMercadoBitcoinAPI\NonceMethods;

interface Method
{

    public function getCurrentNonce();
    public function incrementNonce();
    
}
