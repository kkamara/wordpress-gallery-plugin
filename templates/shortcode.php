<?php
//  security
if (!defined("ABSPATH") || !defined("WPINC")) {
    exit("Do not access this file directly.");
}
// Get the gallery id
$galleryId = $post->ID;
// Get the gallery title
$galleryTitle = $post->post_title;
?>

<style>
    .kkamara-gallery-shortcode-display {
        text-align: center;
        font-weight: bold;
    }
</style>

<div class="kkamara-gallery-shortcode-display">
    [kkamara_gallery title="<?php echo $galleryTitle; ?>" id="<?php echo $galleryId; ?>"]
</div>