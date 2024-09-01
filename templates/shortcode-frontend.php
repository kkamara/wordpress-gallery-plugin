<?php
//  security
if (!defined("ABSPATH") || !defined("WPINC")) {
    exit("Do not access this file directly.");
}
?>
<div class="kkamara-gallery-frontend">
    <div id="kkamara-gallery-images">
        <?php
            // Loop through $kkamaraImages
            foreach($kkamaraImages as $image):
        ?>
            <a href="<?php echo esc_attr($image); ?>">
                <img src="<?php echo esc_attr($image); ?>" />
            </a>
        <?php endforeach; ?>
    </div>
</div>