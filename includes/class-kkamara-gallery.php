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
        // Add shortcode
        add_shortcode(
            "kkamara_gallery",
            array($this, "shortcode"),
        );
        // Enqueue scripts to frontend
        add_action(
            "wp_enqueue_scripts",
            array($this, "enqueueScriptsFrontend"),
        );
    }

    /**
     * enqueueScriptsFrontend
     */
    public function enqueueScriptsFrontend() {
        // CSS for lightgallery
        wp_enqueue_style(
            "kkamara-gallery-lightgallery",
            KKAMARA_GALLERY_URL . "/assets/css/light-gallery.css",
            [],
            KKAMARA_GALLERY_VERSION,
            "all",
        );
        // JS for lightgallery
        wp_enqueue_script(
            "kkamara-gallery-lightgallery",
            KKAMARA_GALLERY_URL . "/assets/js/light-gallery.js",
            ["jquery"],
            KKAMARA_GALLERY_VERSION,
            true,
        );
    }

    /**
     * Shortcode callback
     */
    public function shortcode($atts) {
        // Get the shortcode attributes
        $shortCodeAtt = shortcode_atts([
            "title" => "KKamara Gallery",
            "id" => 200,
        ], $atts, "kkamara_gallery");
        // Return content
        return "Hello " . $shortCodeAtt["title"] .
            " " . $shortCodeAtt["id"];
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
        $kkamaraImages = $this->sanitizeDynamic(
            $_POST["kkamaraImages"]
        );

        // Encode the $kkamaraImages
        $kkamaraImages = json_encode($kkamaraImages);
        
        // Check if it's empty
        if (empty($kkamaraImages)) {
            return false;
        }
        // Log
        // file_put_contents(
        //     __DIR__ . "/log.log",
        //     json_encode($kkamaraImages),
        // );
        // Post meta
        update_post_meta(
            $post_id,
            "kkamaraImages",
            $kkamaraImages,
        );

        return true;
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

        // Add short code
        add_meta_box(
            "kkamara_gallery_shortcode_meta_box",
            "Shortcode",
            array($this, "renderShortcodeMetaBox"),
            "kkamara_gallery",
            "side",
        );
    }

    /**
     * renderShortcodeMetaBox
     */
    public function renderShortcodeMetaBox($post) {
        ob_start();
        include_once KKAMARA_GALLERY_DIR .
            "/templates/shortcode.php";
        $output = ob_get_clean();
        echo $output;
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

    
    //sanitize_array
    public function sanitize_array($array)
    {
        //check if array is not empty
        if (!empty($array)) {
            //loop through array
            foreach ($array as $key => $value) {
                //check if value is array
                if (is_array($array)) {
                    //sanitize array
                    $array[$key] = is_array($value) ? $this->sanitize_array($value) : $this->sanitizeDynamic($value);
                } else {
                    //check if $array is object
                    if (is_object($array)) {
                        //sanitize object
                        $array->$key = $this->sanitizeDynamic($value);
                    } else {
                        //sanitize mixed
                        $array[$key] = $this->sanitizeDynamic($value);
                    }
                }
            }
        }
        //return array
        return $array;
    }

    //sanitize_object
    public function sanitize_object($object)
    {
        //check if object is not empty
        if (!empty($object)) {
            //loop through object
            foreach ($object as $key => $value) {
                //check if value is array
                if (is_array($value)) {
                    //sanitize array
                    $object->$key = $this->sanitize_array($value);
                } else {
                    //sanitize mixed
                    $object->$key = $this->sanitizeDynamic($value);
                }
            }
        }
        //return object
        return $object;
    }

    //dynamic sanitize
    public function sanitizeDynamic($data)
    {
        $type = gettype($data);
        switch ($type) {
            case 'array':
                return $this->sanitize_array($data);
            case 'object':
                return $this->sanitize_object($data);
            default:
                return sanitize_text_field($data);
        }
    }
}

// Init
$init = new KKamara_Gallery();
$init->init();