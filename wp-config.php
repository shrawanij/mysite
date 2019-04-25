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
define( 'DB_NAME', 'test_db' );

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
define( 'AUTH_KEY',         '<{i(?sRrBWk/C_wL)r|G<#<KstG8Y*Ro{^o=or=;h+FJ*:rfCfuQC6Z^p.AF_AH`' );
define( 'SECURE_AUTH_KEY',  'M9_(2(>z3t61rfNFgxn,P8KzV7P[Z5T67xIB^gb=C5>D]`Bf8krkSb+U+C0zyjq_' );
define( 'LOGGED_IN_KEY',    'rVHin1pYZ21}_J)s|FY272*~]?|}%N5Ek,F!M!So{3w_egaZ.gfhM2+4~O:5r-(E' );
define( 'NONCE_KEY',        'R>) ti/At<UPbMQc*2:lT:j=]*DjU|@7w|s/TYr$(JLm{%#wjaMs&.T0ox$AD2aZ' );
define( 'AUTH_SALT',        '<A?;pmQWu_>Qy[[xXHV$s27ym3%>aP?I8/jM1hEgJK!/Q^W6lRar[8.W&J SLN2*' );
define( 'SECURE_AUTH_SALT', 'a;q*vN2CJ.osWFdQ/<|(J/:w&@}K2p#N-36:]r*Mn`Y`9ZIc<Z{c>|<X)C]Vz$Lf' );
define( 'LOGGED_IN_SALT',   '-h*1GIy}rcdQV+>^r+;E~YvM)If<nRo%%L^ET;{{R0as5cjDBWIvfnF9Wo1HJEI?' );
define( 'NONCE_SALT',       '1@e|)CwuN>U9JC&.3G4yXBJ^Q/?kyJ|nuHt1!1_Np.rD7n~+5rQU|kb,ZB|lL-Lc' );

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
