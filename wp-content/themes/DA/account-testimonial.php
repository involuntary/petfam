<?php

/*
* Template to display testimonials on user's post.
*/

global $userdata, $CORE;
            // echo "<pre>";
            // print_r($userdata->ID);
            // echo "</pre>";

$listing_type_args = array(
    'post_type' => 'listing_type',
    'posts_per_page'    => 1,
    'author'    => $userdata->ID
    );

$listing_type_query = new WP_Query( $listing_type_args );

if ( $listing_type_query->have_posts() ) {
    ?>
    <div class="panel panel-default" id="MyFeedback" style="display: none;">
    <!-- <div class="panel panel-default"> -->
        <div class="panel-body">
            <h3>PetFam Member Testimonials</h3>
            <p>Had a great exchange? Request and leave testimonials to help others know how awesome you both are!</p>

            <?php
            while ( $listing_type_query->have_posts() ) {
                $listing_type_query->the_post();

                global $post;
                echo $CORE->get_comment_form($post->ID, $atts['tab']).hook_shortcode_comments('');
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <?php
}