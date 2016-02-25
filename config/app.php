<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br', 'portuguese');

return [

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'America/Sao_Paulo',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'AyTR8ICxBSDViC6NahRYvJUBVNt2Iknq'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => 'daily',

    /*
    |--------------------------------------------------------------------------
    | Version Number of the App
    |--------------------------------------------------------------------------
    |
    | Here come the version of the app for loging and features of the project.
    | Get tue concept from github changelog of all commit and push to the
    | server and bring some kind of documentation in there.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'app_version' => 'v1.0',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Development Service Providers...
         */
        Barryvdh\Debugbar\ServiceProvider::class,

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Routing\ControllerServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Illuminate\Html\HtmlServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        /*
         * Custom Services Providers...
         */
        Collective\Html\HtmlServiceProvider::class,
        Cviebrock\EloquentSluggable\SluggableServiceProvider::class,
        Vinkla\Pusher\PusherServiceProvider::class,
        Zizaco\Entrust\EntrustServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        MaddHatter\LaravelFullcalendar\ServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
        Torann\GeoIP\GeoIPServiceProvider::class,
        Alexpechkarev\GoogleGeocoder\GoogleGeocoderServiceProvider::class,
        Dsdevbe\LdapConnector\LdapConnectorServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,

        /*
         * Personalization Services Providers...
         */
        Aws\Laravel\AwsServiceProvider::class,

        /*
         * Automation Services Providers...
         */
        Orangehill\Iseed\IseedServiceProvider::class,

        /*
         * My Services Providers...
         */
        App\Providers\HelperServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'           => Illuminate\Support\Facades\App::class,
        'Artisan'       => Illuminate\Support\Facades\Artisan::class,
        'Auth'          => Illuminate\Support\Facades\Auth::class,
        'Blade'         => Illuminate\Support\Facades\Blade::class,
        'Bus'           => Illuminate\Support\Facades\Bus::class,
        'Cache'         => Illuminate\Support\Facades\Cache::class,
        'Config'        => Illuminate\Support\Facades\Config::class,
        'Cookie'        => Illuminate\Support\Facades\Cookie::class,
        'Crypt'         => Illuminate\Support\Facades\Crypt::class,
        'DB'            => Illuminate\Support\Facades\DB::class,
        'Eloquent'      => Illuminate\Database\Eloquent\Model::class,
        'Event'         => Illuminate\Support\Facades\Event::class,
        'File'          => Illuminate\Support\Facades\File::class,
        'Hash'          => Illuminate\Support\Facades\Hash::class,
        'Input'         => Illuminate\Support\Facades\Input::class,
        'Inspiring'     => Illuminate\Foundation\Inspiring::class,
        'Lang'          => Illuminate\Support\Facades\Lang::class,
        'Log'           => Illuminate\Support\Facades\Log::class,
        'Mail'          => Illuminate\Support\Facades\Mail::class,
        'Password'      => Illuminate\Support\Facades\Password::class,
        'Queue'         => Illuminate\Support\Facades\Queue::class,
        'Redirect'      => Illuminate\Support\Facades\Redirect::class,
        'Redis'         => Illuminate\Support\Facades\Redis::class,
        'Request'       => Illuminate\Support\Facades\Request::class,
        'Response'      => Illuminate\Support\Facades\Response::class,
        'Route'         => Illuminate\Support\Facades\Route::class,
        'Schema'        => Illuminate\Support\Facades\Schema::class,
        'Session'       => Illuminate\Support\Facades\Session::class,
        'Storage'       => Illuminate\Support\Facades\Storage::class,
        'Str'           => Illuminate\Support\Str::class,
        'URL'           => Illuminate\Support\Facades\URL::class,
        'Validator'     => Illuminate\Support\Facades\Validator::class,
        'View'          => Illuminate\Support\Facades\View::class,
        'Form'          => Collective\Html\FormFacade::class,
        'Html'          => Collective\Html\HtmlFacade::class,
        'Form1'         => Illuminate\Html\FormFacade::class,
        'HTML1'         => Illuminate\Html\HtmlFacade::class,
        'Entrust'       => Zizaco\Entrust\EntrustFacade::class,
        'PusherManager' => Vinkla\Pusher\Facades\Pusher::class,
        'Image'         => Intervention\Image\Facades\Image::class,
        'AWS'           => Aws\Laravel\AwsFacade::class,
        'Calendar'      => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,
        'Socialite'     => Laravel\Socialite\Facades\Socialite::class,
        'GeoIP'         => Torann\GeoIP\GeoIPFacade::class,
        'Geocoder'      => Alexpechkarev\GoogleGeocoder\GoogleGeocoderServiceProvider::class,
        'Excel'         => Maatwebsite\Excel\Facades\Excel::class,
        'role'          => Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission'    => Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability'       => Zizaco\Entrust\Middleware\EntrustAbility::class,

    ],

];
