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
    <div class="kkamara-gallery-container-body">
        <div class="kkamara-gallery-container-body-flex">
            <img src="https://images.unsplash.com/photo-1724838818103-a3ff16624686?q=80&w=1947&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
            <p class="removeImage">
                Remove
            </p>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Add click event
        $(".removeImage").click(function(e) {
            e.preventDefault();
            console.log("remove image");
        });
        $(".kkamara-add-image").click(function(e) {
            e.preventDefault();
            console.log("add image");
        });
    });
</script>