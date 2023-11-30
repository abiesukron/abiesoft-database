<?php 

namespace AbieSoft\Application\Utilities;

class Config 
{
    public static function envReader(string $label) : string
    {
        $result = parse_ini_file(__DIR__ . "/../../../.env")[$label];
        return match ($result) {
            default => $result
        };
    }

}