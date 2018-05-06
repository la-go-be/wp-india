<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME','lagobe_prod_dev');

/** MySQL database username */
define('DB_USER', 'lagobe');

/** MySQL database password */
define('DB_PASSWORD', 'lagobe_db');


/** MySQL hostname */
define('DB_HOST', 'lagobe-db.c9xkyd68xrpr.ap-southeast-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define( 'WP_MAX_MEMORY_LIMIT' , '512M' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'cp@a@VAm]%A>+p+|}4m{][IWgP909]ho#E#{FGihnN~tL0[=LZ&y*glz8~P F`Pv');
define('SECURE_AUTH_KEY',  'nLJF~wXQl8%NBm@7T}kmM0?P3n(cfe.}x&XWQNW&en9=fIWrW;l^8-+AVZj7m($H');
define('LOGGED_IN_KEY',    'dP-yt8i($_.T`yw:3>)8|~.b50vm)hKP8@ab.e9X|I:kG6Lr}lK(#Ux&.19b{`,~');
define('NONCE_KEY',        'B92_ *|JI+T<45,Zli/{@ir*FAIzm-q*w:#BYfi2@iZF*WU>]E13L>o%eyz2J^Y2');
define('AUTH_SALT',        '*ifNul+h*4,3-B3e4M+U5QxmtcY!5DN/w{Jr1JgUN7^4Fr_$^[U:{84Ly6X wMI)');
define('SECURE_AUTH_SALT', 'd]q:u|.GHbm*$P.HQjb~^Vcn|1{AK5ok;A}3Nk507~m6jW|gOHod(J?sW-RUh(5{');
define('LOGGED_IN_SALT',   ';5l0+5B4LCT[j;ZkxL@D$xxziRM>t)V;h;cCUm3HV}q6`cK TR*hom`2>YrC;Qu0');
define('NONCE_SALT',       'c-r!M?YDbTh!7ORTC.sotps}FP|IIu(FW|?dz*|^e~i;h C47EqI>]b&$,Ry;S~l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true ); /* save errors to /wp-content/debug.log */
define( 'WP_DEBUG_DISPLAY', false ); /* Show debug messages in HTML */

define('DISALLOW_FILE_MODS',false);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
