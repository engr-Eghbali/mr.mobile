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
define('DB_NAME', 'auto');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '=]B(u::{%HcbS^k^,=_^Zqe(Qoh48=J2%`~4SD<LS|}|9/=JKX$b+Hjqqs?#&&f$');
define('SECURE_AUTH_KEY',  'RTYaT>1m:v-h?O+9:n}B1A5P(/}|p$/>B+H7Uc72pm#KzQrqU4F{P_f}rUG/iuvb');
define('LOGGED_IN_KEY',    '@Gy4k63h#W~</pB=xBSbn>Yb9RGh;*HWNiz<vF)`kZYl)**47%_350.qTZIax*,M');
define('NONCE_KEY',        '@:f )gGE&A)Ab%A3r|G]?H]AMeYZw_A0anzJ+s-&0w]0c@[:3fp9%&b2^S{wy{yg');
define('AUTH_SALT',        'r*-O,)&?qG>QR%a;kp6D^YQY.wrI*Gws}NoUjAlO GkYGe4g,m/az^Sz[*5!M!yF');
define('SECURE_AUTH_SALT', '5zZnK~x,`.WbhI)VLG$u0rIyqKe:ZC%-%,%?;=U6E|No3ijj)3FsnVlx:)O*YBwO');
define('LOGGED_IN_SALT',   '>esyiJ&[V%UH,FxDXLx&6C=#3HYqwV3^U(Y>Ks(.7dS+fU9%a!rWwin{8b!fVN$q');
define('NONCE_SALT',       '4FEOKnm5]7<X@C,h_ON_fpS/YALX&j+bTor,P8(-F/Wtc2_8LZW3#lmH{!-qH?1F');

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
