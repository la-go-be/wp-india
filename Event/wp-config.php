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
define('DB_NAME', 'deveventbooking');


/** MySQL database username */
define('DB_USER', 'lagobe');

/** MySQL database password */
define('DB_PASSWORD', 'lagobe_db');


/** MySQL hostname */
define('DB_HOST', 'lagobe-db.c9xkyd68xrpr.ap-southeast-1.rds.amazonaws.com:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_MEMORY_LIMIT', '64MB');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Oy#.KS!*1K6QL4Z<$nFiVU`VVK@6,AntA/yd2zgS,S!BN1!;i>z*7T)Spq= Oc> ');
define('SECURE_AUTH_KEY',  'wMK!zq[1v>y^P:]j7%b{3=Q$Qx^Viy7@B2S9=a.hTg7)p;;{t]Dt|+YTyLW94M49');
define('LOGGED_IN_KEY',    'rdwMT.x)T0UIw/v6|X#CN~R>43AAd=HkG;idH+3YpF$gn/4inf}|RP> xPu]9[oc');
define('NONCE_KEY',        '46~1e&&@uZ)@4Q?u;,|aU^,v$lLJ[~nYw#zwCk+Oeew2&~,@!#GcQ<}H14+jeSEz');
define('AUTH_SALT',        'MA/(HmP^_4%U+C.:MlJI@?O3kB,. 1Dk*_U$~$>9xW 4E2q<kMII^nNc7>u7@`Mg');
define('SECURE_AUTH_SALT', '*((U4({R~nsAlDHkZdX90XxOM*wvDN]n7m(l5T>qc>W2b0/@+p+YVCK+Dtj^a3J?');
define('LOGGED_IN_SALT',   'LoNAH9N-C8WQ(pZfF%0N$7QCc0?bSY&^^&V: dTc(-iUw.SS0TK2:dY!NG#/-,Nl');
define('NONCE_SALT',       '7u#nNxoqap[`r&bCuVsv#-cwC!G]}hy;f{>&vefnS(Hiwl^Q`v!pb;?v0QDj#HdI');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
