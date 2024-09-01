<?php
// Check if file is accessed directly.
if (!defined("ABSPATH") || !defined("WPINC")) {
    exit("Do not access this file directly.");
}

/**
 * KKamara_Gallery
 */
class KKamara_Gallery {
    public function init() {
        // Add action init
        add_action(
            "init",
            array($this, "registerPostType"),
        );
        // Add meta box
        add_action(
            "add_meta_boxes",
            array($this, "addMetaBox"),
        );
        // Enqueue scripts.
        add_action(
            "admin_enqueue_scripts",
            array($this, "enqueueScripts"),
        );
        // Save post hook.
        add_action(
            "save_post",
            array($this, "savePost"),
            10,
            2,
        );
    }

    /**
     * Save post
     */
    public function savePost($post_id, $post) {
        // Log
        // file_put_contents(
        //     __DIR__ . "/log.log",
        //     json_encode($post),
        // );
        // Check if post type is kkamara_gallery
        if ($post->post_type !== "kkamara_gallery") {
            return false;
        }

        // Get all input data.
        $kkamaraImages = $_POST["kkamaraImages"];
        
        // Check if it's empty
        if (empty($kkamaraImages)) {
            return false;
        }
        // Log
        // file_put_contents(
        //     __DIR__ . "/log.log",
        //     json_encode($kkamaraImages),
        // );
    }

    /**
     * Enqueue scripts
     */
    public function enqueueScripts($hook) {
        // Check if post type is kkamara_gallery
        if ($hook == "post-new.php" || $hook == "post.php") {
            global $post;
            if ($post->post_type == "kkamara_gallery") {
                // Enqueue scripts
                wp_enqueue_media();
            }
        }
    }

    /**
     * Add meta box
     */
    public function addMetaBox() {
        add_meta_box(
            "kkamara_gallery_meta_box",
            "Add Images",
            array($this, "renderMetaBox"),
            "kkamara_gallery",
            "normal",
            "high",
        );
    }

    /**
     * Render meta box
     */
    public function renderMetaBox($post) {
        ob_start();
        include_once KKAMARA_GALLERY_DIR .
            "/templates/add_images.php";
        $output = ob_get_clean();
        echo $output;
    }

    /**
     * Register post type
     */
    public function registerPostType() {
        $args = [
            "label" => "KKamara Gallery",
            "labels" => [
                "name" => "Gallery",
                "singular_name" => "Gallery",
                "menu_name" => "Gallery",
                "name_admin_bar" => "Gallery",
                "add_new" => "Add New Gallery",
                "add_new_item" => "Add New Gallery",
                "new_item" => "New Gallery",
                "edit_time" => "Edit Gallery",
                "view_item" => "View Gallery",
                "all_items" => "All Gallery",
                "search_items" => "Search Gallery",
                "parent_item_colon" => "Parent Gallery:",
                "not_found" => "No Gallery found.",
                "not_found_in_trash" => "No Gallery found in Trash.",
            ],
            "description" => "KKamara Gallery for WordPress",
            "show_ui" => true,
            "supports" => ["title"],
        ];

        register_post_type("kkamara_gallery", $args);
    }
}

// Init
$init = new KKamara_Gallery();
$init->init();