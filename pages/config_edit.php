<?php
# Copyright (c) 2014 Victor Boctor @ MantisHub.com
# Licensed under the MIT license

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_mantistouch_url = gpc_get( 'mantistouch_url' );

if ( !empty( $f_mantistouch_url ) ) {
	$f_mantistouch_url = rtrim( $f_mantistouch_url, '/' ) . '/';
}

plugin_config_set( 'mantistouch_url', $f_mantistouch_url );

print_successful_redirect( 'manage_plugin_page.php' );
