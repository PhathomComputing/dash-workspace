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
define( 'AUTH_KEY',         'hXhwREp/8|vhIou5.P8$gNiAjbC8vgVig2[Hk#)00f rl,mIn5_GT-25],H4?LSb' );
define( 'SECURE_AUTH_KEY',  '5M.4V6g|#eS.< +3p(3Tc:bTLr.Nwj!MAPVlSQEBn?0q!KE]a@nEknNr$-OD-e Q' );
define( 'LOGGED_IN_KEY',    'QyCN!PQ+xvLWx+dIV9#H4GY> 2xB[pCpGA,(kk@i11t6taWqqdM?@[C7D_`_;d^b' );
define( 'NONCE_KEY',        '4N%HFSZuno PJ8Il<Xt80BS(kxlR<*QOC3:l`4q&$aLFrbwi3~{Gq3|vco8|Z}l0' );
define( 'AUTH_SALT',        'Pc@Icsul0;L*!$q~n~0FlJYH(!rnRiOo}@#&G1g(G1gb%o)o])GG~ZPI,s$fZ0XQ' );
define( 'SECURE_AUTH_SALT', 'LLUT@?Gs8K~0&8P({@6Bg5KnaoCC>29<|%?]3n4!wCs1DbRCcj|FRaT0fr{rk4AY' );
define( 'LOGGED_IN_SALT',   'uZ=36WAvngq/j4mcyt.!B84;[[T-h_nRj&GoPNtE&,6iz@W$?WX%#OY|;m<pF,Wx' );
define( 'NONCE_SALT',       '4{~W~phK)(QH2yvaE|8lwB%rD)ZIT5McM++},QfI421GgN[!e{9P}K([`xH!#{Es' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wb_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
