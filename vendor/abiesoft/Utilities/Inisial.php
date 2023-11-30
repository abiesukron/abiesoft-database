<?php 

namespace AbieSoft\Application\Utilities; 

trait Inisial {

    public static function alreadyFile() : bool
    {
        $result = false;
        if(file_exists(__DIR__."/../../../abiesoft")){
            $result = true;
        }
        return $result;
    }

}