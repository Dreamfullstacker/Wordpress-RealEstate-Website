<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'realestate' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'spDw7z,O-3<zKXg#q/=:_m.iaO|-w9#- p]U(uwb4zEM:?% LDVA*k#[=3}#sUP>' );
define( 'SECURE_AUTH_KEY',  'TtdJHn|A:D4Ec34Os<Re*4a{$-,g^KcQ6r[xJs:e*YJyw<K|E=OU}6Eq^7Fn~wu?' );
define( 'LOGGED_IN_KEY',    '@NI/:5G`2sLp?449Y~?m7Jq9c7$SX^L7j_5gbfTqv-lblEdr_-_GwtCM)BEQ5H?}' );
define( 'NONCE_KEY',        '3Q}N9q|KAXXjY-rwqQ~gfY?nkO&O}~+)ZHNwrQhk#_Cur2YFp1Dll/J:E,_5<p@j' );
define( 'AUTH_SALT',        '4c!D=u-{o_%d=F/<T0M$ <CXs`2lE/3cd`9$8!xx@NUL)D(7`cVY)WpXzNnk`#&$' );
define( 'SECURE_AUTH_SALT', 'w7WHxXd>%HK}g16=,@HQpTsdE]nK?AGDTEHe/uc%a:sjIIJO^aOYsexaI&$S3}.?' );
define( 'LOGGED_IN_SALT',   '6>O,!|8248~L<&.pN*Qb(n:~0|rT>8?21FpIfMba5cN&tHAlwsL_T{4~oow*+blm' );
define( 'NONCE_SALT',       'O_VSl]?5NDwkOKOkkB?FtEzmjJG3,{HFAA7Xnit318;1DBqI.8iI`^&a,o/+M7}f' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
