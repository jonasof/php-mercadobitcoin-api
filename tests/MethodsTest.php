<?php

use JonasOF\PHPMercadoBitcoinAPI\NonceMethods\Manual;
use JonasOF\PHPMercadoBitcoinAPI\NonceMethods\Timestamp;
use JonasOF\PHPMercadoBitcoinAPI\NonceMethods\File;


class MethodsTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function testTimestamp()
    {
        $timestamp = new Timestamp();
        $this->assertLessThan(60, time() - $timestamp->getCurrentNonce());
    }
    
    public function testManual()
    {
        $manual = new Manual(1);
        $this->assertEquals(1, $manual->getCurrentNonce());
        $manual->incrementNonce();
        $this->assertEquals(2, $manual->getCurrentNonce());
    }
    
    public function testFile()
    {
        $file = tmpfile();
        $file_path = stream_get_meta_data($file)['uri'];
        file_put_contents($file_path, 1);
        
        $file_class = new File($file_path);
        $this->assertEquals(1, $file_class->getCurrentNonce());
        $file_class->incrementNonce();
        $this->assertEquals(2, $file_class->getCurrentNonce());
        $this->assertEquals(2, file_get_contents($file_path));
        
        fclose($file); //
    }
    
}
