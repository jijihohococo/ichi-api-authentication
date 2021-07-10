# Ichi API Authentication For Laravel

<p>Since I had difficulties in using Laravel Passport due to the conflicts of PHP Version and League Oauth2 Library. I had the idea of developing my own API Authentication driver. This API Authentication library is developed without Oauth2. It is also my first time library development. The usage and library structure is really same as Laravel Passport's structure. It is aimed to use multiple API Authentication Guards in Laravel API Developments without facing difficulties that I had mentioned above. That development had took one week.</p>

<p>This library can be used for Laravel Version 5.6 to 8 with PHP Version 7.0 to above</p>

## License

This package is Open Source According to [MIT license](LICENSE.md)

## Installing Library

<p>Firstly, you need to add some data in your repositories of composer.json as shown as below</p>

```php
"repositories": [
        {
            "name": "jijihohococo/ichi-api-authentication",
            "type": "vcs",
            "url": "git@github.com:jijihohococo/ichi-api-authentication.git"
        }
    ],
```
<p>And then, run below code in command line.</p>

```php
composer require jijihohococo/ichi-api-authentication
```

## Before Using
<p>You need to have "id" , "email" and "password" columns in your user table to use this library.</p>

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
	'expired_at' => $token->expired_at ,
    'refresh_token' => $token->refreshToken ,
    'refreshTokenExpiredTime' => $token->refreshTokenExpiredTime
]);
```

<p>You can test the login of your token like below</p>
<i>You need to make Accept => application/json and Authorization => Bearer {token} in your headers to make login actions.</i>

```php
Route::group(['middleware' => ['auth:user_api']], function() {
	Route::get('user_profile',function(){
		$user=\Auth::guard('user_api')->user();
		dd($user->name);
	});
});
```
<p>You can revoke the login token as shown as below.</p>

```php
Route::group(['middleware' => ['auth:user_api']], function() {
    Route::get('user_logout',function(){
        $user=\Auth::guard('user_api')->user();
        $user->revoke();
        return response()->json([
            'message' => 'Log out successfully'
        ]);
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

<p>You can select all the tokens of selected User By</p>

```php
User::findOrFail(1)->getAllTokens();
```

<p>You can delete the revoked tokens in command line as shown as below</p>

```php
php artisan ichi:remove --revoke
```

<p>You can delete the expired tokens in command line as shown as below</p>

```php
php artisan ichi:remove --expired
```

## Refresh Token

<p>You can refresh token outside of authentication route like that with the headers Accept => application/json and refresh_token => Bearer {refreshToken}</p>

```php
Route::get('refresh_user_token',function(){
    $user=new User;
    $refreshToken=$user->refreshToken();
    return response()->json([
        'name' => $refreshToken->user->name ,
        'token' => $refreshToken->token ,
        'expired_at' => $refreshToken->expired_at ,
        'refresh_token' => $refreshToken->refreshToken ,
        'refreshTokenExpiredTime' => $refreshToken->refreshTokenExpiredTime
     ]);
});
```
<i>The result of refresh token will be null if the refresh token is not exist or refresh token is expired or the parent token of header refresh token is revoked (true)</i>


<p>The default expiration time of refresh token is 5 Days. You can customize this expiration time like below in "app/Providers/AuthServiceProvider.php" </p>

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
        Ichi::setRefreshExpiredAt(now()->addDays(2));
    }

```


### Hope you enjoy!