<?php
//Business/StorageService.php
declare(strict_types=1);

namespace App\Business;

class StorageService
{   
    private string $dir; /* App/Data/Storage/ */
    private static string $extension = '.json';
    
    public function __construct() 
    {
        $this->dir = dirname(__FILE__, 2) . '/Data/Storage/';
    }
    
    public function findFile(string $filename) : ?array
    {   
        $path = $this->dir . $filename . self::$extension;        
        if (!file_exists($path)) {          
            return null;
        }
        $jsonString =  file_get_contents($path);
        return json_decode($jsonString, true);
    }

    public function makeFile(string $filename, array $content) : array
    {  
        $path = $this->dir . $filename . self::$extension;        
        $json_data = json_encode($content, JSON_PRETTY_PRINT);
        file_put_contents($path, $json_data);
        return $this->findFile($filename); 
    }    
}