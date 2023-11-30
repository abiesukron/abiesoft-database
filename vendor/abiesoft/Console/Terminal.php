<?php 

namespace AbieSoft\Application\Console;

use AbieSoft\Application\Console\Database\Backup;
use AbieSoft\Application\Console\Database\Import;
use AbieSoft\Application\Console\Database\Refresh;
use AbieSoft\Application\Console\Database\Restore;
use AbieSoft\Application\Console\Schema\DeleteSchema;
use AbieSoft\Application\Console\Schema\MakeSchema;
use AbieSoft\Application\Utilities\Config;
use AbieSoft\Application\Utilities\Inisial;

class Terminal
{

    use Inisial;
    public function __construct($command)
    {
        if($this->alreadyFile()){

            unset($command[0]);

            $page = "";
            $model = "";

            if(isset($command[1])){
                if(count(explode(":",$command[1])) > 1){
                    $model = strtolower(explode(":",$command[1])[1]);
                    if(
                        $model == "schema"
                        || $model == "import"
                        || $model == "restore"
                        || $model == "backup"
                        || $model == "refresh"
                    ) {
                        $page = explode(":",$command[1])[0];
                        $model = strtolower(explode(":",$command[1])[1]);
                    }else{
                        $page = "";
                        $model = "";
                    }
                }else{
                    $page = $command[1];
                }
            }

            
            return match ($page) {
                'version' => $this->version(),
                '-v' => $this->version(),
                'make' => $this->$model($page, $command),
                'delete' => $this->$model($page, $command),
                'db' => $this->db($model),
                default => $this->help(),
            };
            
        }

    }

    protected function schema($page, $command) 
    {
        unset($command[1]);
        $fc = "";
        $nama = "";
        if(isset($command[2])){
            $fc = $page;
            $nama = $command[2];
        }

        return match($fc) 
        {
            'make' => MakeSchema::run($nama),
            'delete' => DeleteSchema::run($nama),
            default => $this->help(),
        };
    }

    protected function db($model) 
    {
        return match($model) 
        {
            'import' => Import::run(),
            'backup' => Backup::run(),
            'restore' => Restore::run(),
            'refresh' => Refresh::run(),
            default => $this->help(),
        };
    }

    protected function info($command)
    {
        unset($command[1]);
        
        $what = "";
        if(isset($command[2])){
            $what = $command[2];
        }

        return match($what) {
            default => $this->version()
        };
    }

    protected function version()
    {
        echo "\nAbieSoft Database \e[0;102m Version \e[0m\e[0;106m " . Config::envReader('VERSION') . " \e[0m\n\n";
    }

    protected function help() 
    {
        echo "\n\n\e[0;102mHelp! \e[0m\n";
        echo "\e[0;36mAplikasi:\e[0m \n";
        echo "\e[0m     version \n";
        echo "\e[0;36mDatabase:\e[0m \n";
        echo "\e[0m     db:import \n";
        echo "\e[0m     db:refresh \n";
        echo "\e[0m     db:backup \n";
        echo "\e[0m     db:restore \n";
        echo "\e[0;36mSchema Database:\e[0m \n";
        echo "\e[0m     make:schema [nama] \n";
        echo "\e[0m     delete:schema [nama] \n";
        echo "\n";
    }

}