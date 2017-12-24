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
define('DB_NAME', 'daonline_trueusers');

/** MySQL database username */
define('DB_USER', 'daonline_trueusers');

/** MySQL database password */
define('DB_PASSWORD', 'ample@trueusers1');

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
define('AUTH_KEY',         'b38gFpm*EASu}_6k[IuoWwa/v:Uh&;Fh=R?)]%jnoNBI~T7UZCqt^i}ETTJ`1zW0');
define('SECURE_AUTH_KEY',  'EQRJe!9Yk,Ki>YBVF_aupA#_968mHIP8Kt$6nCrY)GHFCue`{2f1>Yw.SOK6F=IX');
define('LOGGED_IN_KEY',    'XP]bg%Un*8SUbj.${yEj8:H^W_#g6DAz}()+Fw[H]1FCkD!fgMe?Q,jhohV2Hq%M');
define('NONCE_KEY',        'TzGlQ9WdbO4-?B@h]&%H6Z<9T<:G#;i*Z{Y*`7lSY.yV!=SR``.<+rz<XU5vp7]*');
define('AUTH_SALT',        'Y%MnH8S]|a1!|>(on!([,vMV757}G4=Cs/K@ILkQEDmQYl~2i3q@w~tZ|O%VK)60');
define('SECURE_AUTH_SALT', '2pE7.T|8HYr!:hmT1;?(zR$#,NRUvg`=4Dzn[f)vjQ0IWN!P}?H:W*!N28tRVtII');
define('LOGGED_IN_SALT',   '0F1#`?591ndsNGuO17lva%g@$2ZyBu>Slvu9KG&kn?GcWo3Y5m}KMaZ6!*$5w?|-');
define('NONCE_SALT',       ']78OKf8aa,1y1ylZ+0>6plU(O~)Drbh@OLh=-KYCmIND&U yvWqrM3m,NP;[on0~');

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
