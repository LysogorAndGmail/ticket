<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Kiev');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('EN');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
    'base_url'   => 'http://ticket.svitgo.com/',
    'index_file' => FALSE,
    //'caching' =>  TRUE,
    ));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);


Cookie::$salt = '656565656555';
/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	//   'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	   'database'   => MODPATH.'database',   // Database access
	   'image'      => MODPATH.'image',      // Image manipulation
	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	    'orm'       => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
       'email'      => MODPATH.'email',  // Email
       'file'       => MODPATH.'file', // my test
    //   'sms'       => MODPATH.'sms', // my test
     //  'calendar'  => MODPATH.'calendar'  // calendar
        'mpdf'       => MODPATH.'mpdf', ///mpdf
        'loc'        => MODPATH.'loc', ///location IP
        'valute'     => MODPATH.'valute', ///
        'googlecon'  => MODPATH.'googlecon', ///googlecon
        'mailer'  => MODPATH.'mailer', ///googlecon
        'xml' => MODPATH.'xml', ///xml
        'regabus' => MODPATH.'regabus'
        
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 
 
Route::set('api', 'api')
    ->defaults(array(
    'controller' => 'api'
));
 
 
Route::set('svitgo', 'svitgo')
    ->defaults(array(
    'controller' => 'svitgo'
));
 
Route::set('404', '404')
    ->defaults(array(
    'controller' => 'errors',
    'action'=>'404'
));


Route::set('errors', 'errors')
    ->defaults(array(
    'controller' => 'errors'
));


Route::set('sysuser', 'sysuser')
    ->defaults(array(
    'controller' => 'sysuser'
));
 
Route::set('adminmess', 'adminmess')
    ->defaults(array(
    'controller' => 'adminmess'
));

Route::set('lang', 'chang_lang')
    ->defaults(array(
    'controller' => 'disp',
    'action'=> 'chang_lang'
));

Route::set('search_routes', 'search_routes')
    ->defaults(array(
    'controller' => 'route',
    'action'=> 'search'
));
 
Route::set('show_group', 'group/<id>')
    ->defaults(array(
    'controller' => 'group',
    'action'=>'show_group'
)); 
 
Route::set('tiket', 'tiket')
    ->defaults(array(
    'controller' => 'tiket'
));

Route::set('news', 'news')
    ->defaults(array(
    'controller' => 'news'
));

Route::set('ost', 'ost')
    ->defaults(array(
    'controller' => 'ost'
));

Route::set('discounts', 'discounts')
    ->defaults(array(
    'controller' => 'discounts'
));

Route::set('groups', 'groups')
    ->defaults(array(
    'controller' => 'groups'
));

Route::set('buses', 'buses')
    ->defaults(array(
    'controller' => 'buses'
));

Route::set('dispusers', 'dispusers')
    ->defaults(array(
    'controller' => 'dispusers'
));

Route::set('ferryman', 'ferryman')
    ->defaults(array(
    'controller' => 'ferryman'
));

Route::set('disp', 'disp')
    ->defaults(array(
    'controller' => 'disp'
));

Route::set('default', '(<controller>(/<action>))')
    ->defaults(array(
    'controller' => 'disp',
    'action'     => 'index'
));
