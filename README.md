# Ichi API Authentication For Laravel

<p>Since I had difficulties in using Laravel Passport due to the conflicts of PHP Version and League Oauth2 Library. I had a idea of developing my own API Authentication driver. This API Authentication library is developed without Oauth2. It is also my first time library development. The usage and library structure is really same as Laravel Passport's structure. It is aimed to use multiple API Authentication Guards in Laravel API Developments without facing difficulties that i had mentioned above. That development had took one week.</p>

<p>This library can be used for Laravel Version <=5.6 and PHP Version <=7.0</p>

## Using the library

<p>To use the library, firstly we need to assign the guards like below code in "config/auth.php" of your Laravel Project. </p>

```php
'guards' => [
	'user_api' => [
		'driver' => 'ichi',
		'provider' => 'users',
		'hash' => false,
	],
]
```

<p>And then we need to add User API Guard into Ichi API Database by the below code in terminal</p>

```php
php artisan ichi:client --password
```

<p>After choosing the right guard for your user in terminal as you mentioned in your guard array of "config/auth.php", your User Model need to inherit this library functions by the inheritance as shown as below.</p>

```php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JiJiHoHoCoCo\IchiApiAuthentication\HasApi;
class User extends Authenticatable{
	use HasApi;
}
```

<p>The configuration is finished, you can override the database models of Ichi library with command line as shown as below.</p>

```php
php artisan vendor:publish --tag=ichi-migrations
```

<p>You can also override the configurations of Ichi Library with command line as shown as below</p>

```php
php artisan vendor:publish --tag=ichi-config
```

<p>You can test the registration of your token like below</p>

```php
$user= User::create([
	'name' => 'jiji' , 
	'email' => 'ji@gmail.com' ,
	'password' => Hash::make( 'password' )
]);
$token=$user->ichiToken();
return response()->json([
	'name' => $user->name ,
	'token' => $token->token ,
	'expired_at' => $token->expired_at
]);
```

<p>You can test the login of your token like below</p>

```php
Route::group(['middleware' => ['auth:user_api']], function() {
	Route::get('user_profile',function(){
		$user=\Auth::guard('user_api')->user();
		dd($user->name);
	});
});
```

<p>The default expiration time of token is 5 Days. You can customize this expiration time like below in "app/Providers/AuthServiceProvider.php" </p>

<i>Gate has no connection with our library.</i>

```php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use JiJiHoHoCoCo\IchiApiAuthentication\Ichi;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Ichi::setExpiredAt(now()->addDays(2));
    }

```
### Hope you enjoy!