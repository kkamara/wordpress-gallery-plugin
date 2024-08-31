<?php
//  security
if (!defined("ABSPATH") || !defined("WPINC")) {
    exit("Do not access this file directly.");
}
?>
<style>
    .kkamara-gallery-container-header {
        margin-bottom: 20px;
        border-bottom: 1px solid lightgray;
        padding-bottom: 10px;
        text-align: center;
    }
    .kkamara-gallery-container-body-flex {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 10px;
    }
    .kkamara-gallery-container-body-flex img {
        width: 75px;
        height: 50px;
        object-fit: contain;
        object-position: center;
    }
    .kkamara-gallery-container-body-flex p {
        margin: 0px;
        margin-left: 10px;
        color: red;
        cursor: pointer;
    }
    .kkamara-gallery-container-body-flex p:hover {
        text-decoration: underline;
        color: black;
    }
</style>
<div class="kkamara-gallery-container">
    <div class="kkamara-gallery-container-header">
        <button
            type="button"
            class="button button-primary button-large kkamara-add-image"
        >
            Add Images
        </button>
    </div>
    <!-- Body -->
    <div class="kkamara-gallery-container-body"></div>
</div>

<script>
    // Add on-click event
    const removeImageKKamaraGallery = (elem, e) => {
        e.preventDefault();
        jQuery(document).ready(function ($) {
            var element = $(elem);
            // Remove the parent element.
            element.parent().remove();
        });
    };

    jQuery(document).ready(function($) {
        $(".kkamara-add-image").click(function(e) {
            e.preventDefault();
            // Loop WP Media
            var mediaUploader = wp.media({
                title: "Select Image",
                button: {
                    text: "Select Image",
                },
                multiple: false,
            });

            // On Select
            mediaUploader.on("select", function() {
                var attachment = mediaUploader.state()
                    .get("selection")
                    .first()
                    .toJSON();
                // Image URL
                var imageURL = attachment.url;
                // Append to kkamara-gallery-entry
                $(".kkamara-gallery-container-body").append(
                    `
                        <div class="kkamara-gallery-container-body-flex">
                            <input type="text" name="kkamaraImages[]" value="${imageURL}" />
                            <img src="${imageURL}" alt="${attachment.alt}" />
                            <p class="removeImage" onClick="removeImageKKamaraGallery(this, event)">
                                Remove
                            </p>
                        </div>
                    `
                );
                // Log
                console.log(attachment);
            });

            mediaUploader.open();
        });
    });
</script>