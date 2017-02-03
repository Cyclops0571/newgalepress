<?php

/*
  This is an example plugin for Tickets.
  Copyright Dalegroup Pty Ltd 2012

  You may use this code to help write your own plugins for Ticlets.

  If you do write any plugins we suggest submitting them to Codecanyon.
 */

/*
  Required.
  You must include these two lines at the start of your plugin.
 */

namespace sts\plugins;

use sts;

/*
  The class name must be the same as your plugin file name.
  We recommend you use a prefix for your class and function names.

  bbawesome.plugin.php would have the class bbawesome
 */

class auth {

    function __construct() {
        /*
          This will get called on the plugins settings page.
          Please use the load method for startup and not this constructor.
         */
    }

    /*
      This method is used to get the plugin details.
      It is required.
     */

    public function meta_data() {
        $info = array(
            'name' => 'Auth Plugin',
            'version' => '1.0',
            'description' => 'This is a auth plugin for galepress users',
            'website' => 'www.galepress.com',
            'author' => 'Serdar Sayglı',
            'author_website' => 'http://serdarsaygili.com/'
        );

        return $info;
    }

    /*
      This function is called on each page load if the plugin is enabled.
      It is required.
     */

    public function load() {

        //this is how you get an existing class
        $plugins = &sts\singleton::get('sts\plugins');
        $plugins->add(
                array(
                    'plugin_name' => 'auth',
                    'task_name' => 'galepress_custom_login',
                    'section' => 'auth_login_start',
                    'method' => array(__NAMESPACE__ . '\auth', 'auth_login_start')
                )
        );
    }

    public function auth_login_start() {
//        var_dump($_COOKIE); exit;version_1
    }

    public function plugin_page_header_test() {
        $site = &sts\singleton::get('sts\site');

        //this sets the title of the page.
        $site->set_title('Test');
    }

    public function public_page_header_anon() {
        $site = &sts\singleton::get('sts\site');

        //this sets the title of the page.
        $site->set_title('Anon');
    }

}
?>