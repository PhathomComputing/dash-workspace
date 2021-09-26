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
define( 'DB_NAME', 'workbench' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'JAzav!n)^Zt`WIr1H9Z0H&|yGZ<#J{t}Q.|()IfzfHbG`rb=Yx=7l-g&[L ;590z' );
define( 'SECURE_AUTH_KEY',  '#QY!X9}f~@]GbrEv=J<LQbTb{O}N<S9BSVryd-_^<pt}Ew;~B[/cj&{Iv:mbRX4c' );
define( 'LOGGED_IN_KEY',    '4H*%:{Erwb8{GcU+<p97}cB-6?@{Jdi5wu.34Q#th9=ig|jD`uNayjLooulD.SS~' );
define( 'NONCE_KEY',        'IVSCJ#i_,MD&/:7?G%kK3yA1dfYMJIwX]O/YYJ{rwnTO0@j=g&$#W`1|{]4syBBA' );
define( 'AUTH_SALT',        'G#eMr.Db2y(<OovJ~REK8y{g@BM3hIl+cQ6+R9gz/ nuM{q:>&(f&ps1UF@0F&S0' );
define( 'SECURE_AUTH_SALT', '`~f%c<zcpKW$(6(qRN]lo!T;o#U/Mc rnf~H3t4rz&[-Z^`awBeIP3/Y6Ch9sM%i' );
define( 'LOGGED_IN_SALT',   'e=gq|bp9C1t:vO]}VVXN+jw+=3eG*Mru/3@zTv<G$N.5Raa$+6~b;6Q[_WLN~&zs' );
define( 'NONCE_SALT',       'W6A}O*z()!T]~.uaAJ%H>U-X8=t(i4$=a^m$+3D?q,i(tz4rCuhi*Nahc@n=VlZt' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wb2_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
