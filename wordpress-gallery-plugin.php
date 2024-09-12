<?php
/**
 * Plugin Name: KKamara Gallery
 * Plugin URI:  https://github.com/kkamara/wordpress-gallery-plugin
 * Author:      Kelvin Kamara
 * Author URI:  https://kelvinkamara.com
 * Description: A simple gallery plugin for WordPress.
 * Version:     0.1.0
 * License:     BSD-3-Clause
 * License URL: https://opensource.org/license/bsd-3-clause
 * text-domain: kkamara-gallery
*/

// Check if file is accessed directly.
if (!defined("ABSPATH") || !defined("WPINC")) {
    exit("Do not access this file directly.");
}

// Define plugin constants.
define("KKAMARA_GALLERY_VERSION", "0.1.0");
// Plugin file.
define("KKAMARA_GALLERY_FILE", __FILE__);
// Plugin directory.
define(
    "KKAMARA_GALLERY_DIR",
    dirname(KKAMARA_GALLERY_FILE),
);
// Plugin URL.
define(
    "KKAMARA_GALLERY_URL",
    plugins_url("", KKAMARA_GALLERY_FILE),
);

// Check if class exists.
if (!class_exists("KKamara_Gallery")) {
    // Include the class file
    include_once KKAMARA_GALLERY_DIR . 
        "/includes/class-kkamara-gallery.php";
}
