<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Console;
use Illuminate\Console\Command;
use JiJiHoHoCoCo\IchiApiAuthentication\Repository\ClientRepository;
class ClientApiAuthCommand extends Command{

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

    public function handle(ClientRepository $client){
        if($this->options('password')){
            $this->createPasswordClient($client);
        }

    }

    public function createPasswordClient(ClientRepository $client){


        $guards= (array)collect(config('auth.guards'))->where('driver','ichi');
        $selectedArray=$guards[ array_key_first($guards) ];
        $guard = $this->choice(
            'Which user guard should this client use to retrieve users?',
            array_keys($selectedArray),
            'users'
        );
        if($client->checkGuardDuplicate($guard)==0){
            $client->create($guard,$selectedArray);

            $this->info('Password grant client created successfully.');
        }else{
            $this->error('Duplicate Guard');
        }

    }

}