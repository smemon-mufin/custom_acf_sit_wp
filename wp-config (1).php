<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
define( 'FORCE_SSL_ADMIN', true ); // Redirect All HTTP Page Requests to HTTPS - Security > Settings > Enforce SSL
// END iThemes Security - Do not modify or remove this line

# Database Configuration
define( 'DB_NAME', 'wp_aboutsib2023' );
define( 'DB_USER', 'aboutsib2023' );
define( 'DB_PASSWORD', 'Z8kR3FeCpb3LJwvXxeEo' );
define( 'DB_HOST', '127.0.0.1:3306' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '`4bfWbqL%>%{RbRWsbG.{-gD+*XxKCl9FS($Hvb!j|TD7s$6[fs=(8P]uG{/46vR');
define('SECURE_AUTH_KEY',  'oq&|zG|&|~L2}iSVu5h+UKVafpMw?6MWa`v8A!DA~vTfap) c~VTCEX%j8V0z{HN');
define('LOGGED_IN_KEY',    '5=*-=cA>Pz-{-S}Z}5,?.(YJHxZn&hy_fHC`.7bx>]n&DAfMdf|i;`ljj8ntzW/E');
define('NONCE_KEY',        'rj.8wSSxb4uHfo@|29nNzlWT6Q|rM:?E:=Sm!bdvLIaZWfB@`!Q~kKX`rnEMU*]_');
define('AUTH_SALT',        '|Jd-K`QB3pjXGbe_r/|Bumnk.O/G&h$#ZWKEq,,;<;9>08{wO`w3>foSYac<|9;q');
define('SECURE_AUTH_SALT', '%,>@O+tf+ kQZ.YNYpN/TC]ZpxQ`eJZfROG~QRZGCj5iKx?+}!Gz#?evih+Tg+!7');
define('LOGGED_IN_SALT',   ':nO$NQ)Vj?xBa~!xBF&Eb^fAn0RYkbi;m,XIH-@4a#>Mq>M]/,s/Al>XD-wgNrPs');
define('NONCE_SALT',       'Womh}U!$kb|SZmJ}^7?+KN~kdL3-(<mr*k)fLHbSW4T+>+zzv}8`hZo|Q^#1WH_p');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'aboutsib2023' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'WPE_APIKEY', 'ea72c56140881ee41045d13b7ec9e78b582e6283' );

define( 'WPE_CLUSTER_ID', '202210' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_SFTP_ENDPOINT', '34.82.42.47' );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'aboutsib2023.wpengine.com', 1 => 'aboutsib2023.wpenginepowered.com', 2 => 'aboutsib.com', 3 => 'www.aboutsib.com', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '35.233.187.204', 1 => 'pod-202210-utility.pod-202210.svc.cluster.local', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');
