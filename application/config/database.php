<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/


$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = '';
$db['default']['database'] = 'recetario';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['bitwit']['hostname'] = '184.154.125.130';
$db['bitwit']['username'] = 'bitwitco_admin';
$db['bitwit']['password'] = 'adminbitwitco1';
$db['bitwit']['database'] = 'bitwitco_creatibooks';
$db['bitwit']['dbdriver'] = 'mysql';
$db['bitwit']['dbprefix'] = '';
$db['bitwit']['pconnect'] = TRUE;
$db['bitwit']['db_debug'] = TRUE;
$db['bitwit']['cache_on'] = FALSE;
$db['bitwit']['cachedir'] = '';
$db['bitwit']['char_set'] = 'utf8';
$db['bitwit']['dbcollat'] = 'utf8_unicode_ci';
$db['bitwit']['swap_pre'] = '';
$db['bitwit']['autoinit'] = FALSE;
$db['bitwit']['stricton'] = FALSE;

$db['sitio']['hostname'] = '10.33.143.24';
$db['sitio']['username'] = 'creatibo_dmin';
$db['sitio']['password'] = '1EfXJ3Lrwl9T';
$db['sitio']['database'] = 'creatibo_main';
$db['sitio']['dbdriver'] = 'mysql';
$db['sitio']['dbprefix'] = '';
$db['sitio']['pconnect'] = TRUE;
$db['sitio']['db_debug'] = TRUE;
$db['sitio']['cache_on'] = FALSE;
$db['sitio']['cachedir'] = '';
$db['sitio']['char_set'] = 'utf8';
$db['sitio']['dbcollat'] = 'utf8_unicode_ci';
$db['sitio']['swap_pre'] = '';
$db['sitio']['autoinit'] = FALSE;
$db['sitio']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */