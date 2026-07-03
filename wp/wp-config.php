<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */


define( 'WP_HOME',    'https://pcccphuoclong.vn' );
define( 'WP_SITEURL', 'https://pcccphuoclong.vn' );

define( 'DB_NAME', 'pccc' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'pPp]$Ayfw]}$pCxaCJ:O8*^`6yGx([: [2X7N1{:%t4IN3y47k:`#:Tm&Ru`zUEL' );
define( 'SECURE_AUTH_KEY',   'c/|1=_g,;XmIY@.$L9SWa&w)Fdw~y-S{#}#HFfHGPRjcdqe6*y^F`>XUV*j(_yZb' );
define( 'LOGGED_IN_KEY',     '~sO-.5}li!?q;eTa4uO4A,TFq@hol8g9?@qU<|W2/0rcVdy._%WNnSq`mSSC6f+3' );
define( 'NONCE_KEY',         'sUVN7<]<}KvkO|efLK r8W .JXAB[W8dnsuTkv&2HT=ArWl1a;emWE,Ie|{0[nmr' );
define( 'AUTH_SALT',         'yi9:]t{;<s_L-bP8f*+?Znv(kGO7N4C,(PyZ3Z=Y_B{dLxr4dkmvOCYYf7@9#oCZ' );
define( 'SECURE_AUTH_SALT',  'L9l6hym~:gm@ ISEF&|zxO60,GM mgz~Q]a`UTQl^<$S@,Y8iugrGTEo`x./u^@e' );
define( 'LOGGED_IN_SALT',    '45w5^. #b~06HFx-G_Y(z9*$Jr}ZE1~)!rJ5v;@:4ULQ&2NV?~)Hy#(T6hvj#hBH' );
define( 'NONCE_SALT',        'KcCN;24o_h| W-/Vf>8>ULbb<oxMQ7gLJv~IoA5ea{<o@O?5~/z$p}k9$*r8:m <' );
define( 'WP_CACHE_KEY_SALT', '6gU/emWxr|z+@u.)55m6WA_@9W~YLe{|42}-Pagu&)XT>-:zX~V_<<s&d*3Z#6]u' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
