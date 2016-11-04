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
define('DB_NAME', 'niko_directory');

/** MySQL database username */
define('DB_USER', 'niko');

/** MySQL database password */
define('DB_PASSWORD', 'aND6ytc');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$0ZZ,R7XCPGvp1At$Iin,mBS*IQ5<ey3n^TC0>aO7+gF84=G`eqab+ {C4<f8c7-');
define('SECURE_AUTH_KEY',  'Y5~B(^xx=K<lj)UV[43qBvyxL<wQU{edUZ+9 Sg>Snn%C0>ntc.YZo,-gxZY)tt-');
define('LOGGED_IN_KEY',    '&j(3OM@Uh9FSzrlmL_0KRmzt!ZT`x%r6II|fD=1I*NRd%E9ke!4 UqQGD&;=#Eu2');
define('NONCE_KEY',        'YRb9g(VJWBgiBzB7u/qd9Q=w@FXxN+w?I&%(8<S{4#X@1Ox~P,.+0~RUC5^k$j! ');
define('AUTH_SALT',        'TcDbEQ.54+w}e/dPYPDfSy2rXi R3~X>x]K=GMjQP=G]_TX*Qu=dY2]9{v/Am3AW');
define('SECURE_AUTH_SALT', '`ih^hFVy.;F|~!N0rI}7WG4M3KPOCelrc{bC{N}o`.Z2P[X]8Xz)^e}{d39$/.A+');
define('LOGGED_IN_SALT',   'UDT;LE<-x<Vs|ypcNy;!1CjR{h;V46d~e;*s69lS+X$[SB!{lF^B)R!`^?xA2u>7');
define('NONCE_SALT',       '.0h/|.Z3 8w7,lLzXxqOb3JxoTSV&8iAj<#.-c]B_DL*%#h!Em<_5%JU!9=%[eS8');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
