<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Y=i7^`r/wBofhDx?_aS_Ou^{PRG,43s-Wwv{zYwS$6#}soC1{*BZJ$%I4{<f1J0I');
define('SECURE_AUTH_KEY',  'V$>8Qh-DL[ps9M&8#{4g4XTiWpFJq[?&!+^r72eHOx#)S:JK-GQU%H9?jG-I2=!V');
define('LOGGED_IN_KEY',    '>0gQqSl-|-}v?634<H@-Peb0BV-(0Xa<6 >*z:YG|uhgQ]t}81Dnym&;A|3ex{s;');
define('NONCE_KEY',        'd;s5XiI1flq$~<C&_ZWR7#^G,!|+If|{dB(e8Za?&3}aF||aw_tGgrd|b5wN_E]4');
define('AUTH_SALT',        '>t|VNv5+H+T*$aJf. (?ut|,*#;%}b?eS&Dn-{?Gz26]w[o~lb*,#%#&LJS@_c(6');
define('SECURE_AUTH_SALT', '7+_[A,F$bmLlP?7,Y}+tQ9QeQW6wBr3$7cz0~$]d&,(#%fvH.7`j_@U)_}^1)B5T');
define('LOGGED_IN_SALT',   'R1bBsA8lhtHK1B:lG?[2W|TbY67{1!MaK6=B i.d` d`|AJ,N[og+gI~&iTL4SbR');
define('NONCE_SALT',       'bbp;!umdrY+2h>(]k{uY*irW|S96#pW}64*6S%%E+)ErcxxLId-|/JB4$_w3J5eX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
