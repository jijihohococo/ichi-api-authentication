<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Console;
use Illuminate\Console\Command;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\IchiTokenAuthentication;
use Carbon\Carbon;
class RemoveApiAuthCommand extends Command{

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ichi:remove
    {--revoke : Remove revoked tokens }
    {--expired : Remove expired tokens}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the unused tokens';

    public function handle(){
    	if($this->options('revoke')){
    		$this->removeRevokedTokens();
        }elseif($this->options('expired')){
        	$this->removeExpiredTokens();
        }
    }

    public function removeRevokedTokens(){
    	IchiTokenAuthentication::where('revoke',1)
    	->delete();
    	$this->info('Revoked Tokens are deleted successfully.');
    }

    public function removeExpiredTokens(){
    	IchiTokenAuthentication::where('expired_at','<=',Carbon::now())
    	->delete();
    	$this->info('Expired Tokens are deleted successfully.');
    }
}