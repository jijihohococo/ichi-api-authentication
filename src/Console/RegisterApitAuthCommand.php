<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Console;
use Illuminate\Console\Command;
class RegisterApiAuthCommand extends Command{

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ichi:client
            {--password : Create a password grant client}';

	/**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Provider with guard to access api tokens';

    public function handle(){

    }

    public function createPasswordClient(){
    	
    }

}