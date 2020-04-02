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
define( 'DB_NAME', 'wordpress_test' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'admin' );

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
define( 'AUTH_KEY',         ')}@y))`/0eI4;lx[!|0c#>|-+obF1n}[-w8E7fQgn(`Pe3XTw0=V*+;`}[MasT%#' );
define( 'SECURE_AUTH_KEY',  'PC$}w6shp01;5(=r/?+4-mV;pG /6Pw_<$ElS6,c/3H{z1+`qs9S!f0pD$x|.[qx' );
define( 'LOGGED_IN_KEY',    'ik-fw18TsJ7+gW6)o?}boR`ullHGJt/N?gs s!C7;IPR@Fc{MkP,dLwY5ZT{8<Im' );
define( 'NONCE_KEY',        '~.Q.Wu:UGxk9lSDW6awHw_Redff._o`JZ/?,PhGi6$gm`I3rivWpAlhdy|P?Ne# ' );
define( 'AUTH_SALT',        ';I1@8m);-o6_s58)RjRvL0bz*Y)B74Akf8@0]BBY-QT6fuIKZa7x|N5*-Z@bYJ/x' );
define( 'SECURE_AUTH_SALT', 'q]CfT&dFtRpCZU+2-0QEsH%^#juUwh@:d3<O@h-ZpNVe 8D*`W9S!}S:/b4=(cU|' );
define( 'LOGGED_IN_SALT',   't=H]iA0? X<P+<B3Db2BTZ8tPeJr,[*;15U,@~.UcfPn=o8xTp|9i#GfFq%/G:Z$' );
define( 'NONCE_SALT',       '7*9GQ_Ez@x4*c)b:.kZSN;2WXC1SpF%1GDm6`i:ktE)TW(ukYrG;Y]d:&qSAoV!+' );

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
