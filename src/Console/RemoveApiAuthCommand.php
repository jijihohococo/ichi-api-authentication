<?php

namespace JiJiHoHoCoCo\IchiApiAuthentication\Console;
use Illuminate\Console\Command;
use JiJiHoHoCoCo\IchiApiAuthentication\Models\{IchiTokenAuthentication,IchiRefreshTokenAuthentication};
use Carbon\Carbon;
class RemoveApiAuthCommand extends Command{

	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ichi:remove
    {--revoke : Remove revoked tokens }
    {--expired : Remove expired tokens}
    {--revoke_refresh_token : Remove revoked refresh tokens}
    {--expired_refresh_token : Remove expired refresh tokens}';

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
        }elseif($this->options('revoke_refresh_token')){
            $this->removeRevokedRefreshTokens();
        }elseif($this->options('expired_refresh_token')){
            $this->removeExpiredRefreshTokens();
        }
    }

    public function removeRevokedTokens(){
    	IchiTokenAuthentication::removeRevokedTokens();
    	$this->info('Revoked Tokens are deleted successfully.');
    }

    public function removeExpiredTokens(){
    	IchiTokenAuthentication::whereExpiredTokens()->delete();
    	$this->info('Expired Tokens are deleted successfully.');
    }

    public function removeRevokedRefreshTokens(){
        IchiRefreshTokenAuthentication::removeRevokedTokens();
        $this->info('Revoked Refresh Tokens are deleted successfully.');
    }

    public function removeExpiredRefreshTokens(){
        IchiRefreshTokenAuthentication::whereExpiredTokens()->delete();
        $this->info('Expired Refresh Tokens are deleted successfully.');
    }
}