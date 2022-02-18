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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'secrets.DB_NAME' );

/** MySQL database username */
define( 'DB_USER', 'secrets.DB_USER' );

/** MySQL database password */
define( 'DB_PASSWORD', 'secrets.DB_PASSWORD' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|kw,yaMSz<$RT+W|^~_z$ cn,L4#&).rQNp`P*uaxlw0e;Siv1;e|};k;,R,*PgT' );
define( 'SECURE_AUTH_KEY',  'Q54N$HE(;|uwLX13,==+z)&7SW9}.VoneDoZ*e/C1pJ?KS.}K^x=#r7Eq(NM=mJr' );
define( 'LOGGED_IN_KEY',    ')!uBKXPs6?[wz<,@b`^q*~.ie/7u_r`mk:g_Y>PmE|M?wr]U`!@;mN17g4=UHKnS' );
define( 'NONCE_KEY',        'j~o5FU-JU!w,ovbQ]%uC,sQQeYt#vTR7W$@E:d9nYpq(}iBhN y <jWU4y&uwhvP' );
define( 'AUTH_SALT',        ' p5[0nM[kuSg.|7~.>cP(cuD&/BljSu$1M)MRW[qcoZm n`?^N),p10-UGSF3Mee' );
define( 'SECURE_AUTH_SALT', 'sjNgelYfN}zch2q_hk09xNzsUGxm9-* cry}VNZf5.1pE{Hc_Ni3vNOfDwry`/Rr' );
define( 'LOGGED_IN_SALT',   'T_IgVi $/haKAEv5s&~~!/$)~OUNDXqXa sc&Puw=q3A<+`L*8Mj@x_PGFd$^u@7' );
define( 'NONCE_SALT',       ';=4gH;0uOX}&99O=T0V}>zt<WW7wj^y?zK>Xa/+o@;VCH {5MiSR&L~%b5g}N+ Z' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', true );
// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
