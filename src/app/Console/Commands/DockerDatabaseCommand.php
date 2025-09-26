<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DockerDatabaseCommand extends Command
{
    protected $signature = 'docker:database';

    protected $description = 'Command description';

    public function handle(): void
    {
        try{
            //check if User-Table exists?
            if(User::exists()){
                $this->call("migrate"); // run migrations
                echo "true";
                return;
            }
            $this->call('migrate:fresh');
            $this->call("db:seed");
            echo "true";
            return;

        }catch (\Exception $exception){
            $message = $exception->getMessage();
            if(str_starts_with($message, "SQLSTATE[42S02]")){
                //Base table not found
                $this->call('migrate:fresh');
                $this->call("db:seed");
                echo "true";
                return;
            }else if(str_starts_with($message, "SQLSTATE[HY000]")){
                //access denied
                echo "false";
                return;
            }else{
                echo $message;
                echo "false";
            }
        }

    }
}
