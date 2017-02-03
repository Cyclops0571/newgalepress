<?php
namespace sts;

/*
	STS Config File
	
	You should only need to change: database_hostname, database_username, database_password, database_name and salt
	
	Database Charset should always be UTF8
	Database Table Prefix should always be empty
	SITE ID should always be 1	
*/
if (!defined(__NAMESPACE__ . '\SEC_DB_LOADED')) {
    $config =
        array(
            'database_hostname' => 'localhost',
            'database_username' => 'galepress_ticket',
            'database_password' => ':Ekt4eca',
            'database_name' => 'galepress_ticket',
            'database_type' => 'mysql',
            'database_charset' => 'UTF8',
            'database_table_prefix' => '',
            'site_id' => 1,
            'salt' => 'F4ECz6v9oCWOYeVAD705RDGgoXqgmFmg'
        );
    if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        $config['database_username'] = 'root';
        $config['database_password'] = '';
    }
}
?>