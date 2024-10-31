<?php

if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.', 'plksc' ) );
}

// Now display the settings editing screen

echo '<div class="wrap">';

echo "<h1>" .  __( 'Settings', 'plksc' ) . "</h1>";

plksc::plksc_inner_menu();
?>

<div id="poststuff">

    <!-- Main content -->
    <div id="post-body" class="metabox-holder columns-2">

        <div id="postbox-container-2" class="postbox-container">
            <div id="top-sortables" class="meta-box-sortables ui-sortable"></div>
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                <div id="plksc_options" class="postbox">

                    <h2 class="hndle ui-sortable-handle"><span><?php _e("Shortcode generation", 'plksc' ); ?></span></h2>
                    <div class="inside">

                            <table class="form-table" id="global">
                                <tbody>
                                <tr>
                                    <th scope="row"><?php _e("Custom text content", 'plksc' ); ?></th>
                                    <td><input type="text" id="textvalue" name="textvalue" class="toWatch" value="">
                                        <label><?php _e("", 'plksc' ); ?></label>
                                        <p class="description"><?php _e("Choose the text you wish inside your shortcode", 'plksc' ); ?></p></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e("Select the post you wish to use", 'plksc' ); ?></th>
                                    <td>
                                        <?php
                                        /**
                                         * array
                                         * return id (if post, page, etc..), url, name, disabled (boolean)
                                         */
                                        $plksc_urls = array();

                                        /**
                                         * categories
                                         */
                                        $plksc_categories = get_categories();

                                        if($plksc_categories) {

                                            $newdata = array(
                                                'id' => '',
                                                'term_id' => '',
                                                'name' => __('--------- Categories ----------', 'plksc'),
                                                'type' => '',
                                                'disabled' => true
                                            );
                                            array_push($plksc_urls, $newdata);

                                            foreach ($plksc_categories as $plksc_category) {
                                                $newdata = array(
                                                    'id' => intval($plksc_category->term_id),
                                                    'term_id' => get_category_link($plksc_category->term_id),
                                                    'name' => $plksc_category->name,
                                                    'type' => 'cat',
                                                    'disabled' => false
                                                );
                                                array_push($plksc_urls, $newdata);
                                            }
                                        }

                                        /**
                                         * tags
                                         */
                                        $plksc_tags = get_tags();

                                        if($plksc_tags) {
                                            // insert title separation
                                            $newdata = array(
                                                'id' => '',
                                                'term_id' => '',
                                                'name' => __('--------- Tags ----------', 'plksc'),
                                                'type' => '',
                                                'disabled' => true
                                            );
                                            array_push($plksc_urls, $newdata);

                                            // loop on tags
                                            foreach ($plksc_tags as $plksc_tag) {
                                                $newdata = array(
                                                    'id' => intval($plksc_tag->term_id),
                                                    'term_id' => get_term_link($plksc_tag->term_id),
                                                    'name' => $plksc_tag->name,
                                                    'type' => 'tag',
                                                    'disabled' => false
                                                );
                                                array_push($plksc_urls, $newdata);
                                            }
                                        }


                                        /**
                                         * page
                                         */
                                        $newdata =  array (
                                            'id' => '',
                                            'term_id' => '',
                                            'name' => __('--------- Page ----------', 'plksc'),
                                            'type' => '',
                                            'disabled' => true
                                        );
                                        array_push($plksc_urls, $newdata);

                                        $args = array(
                                            'post_type' => array('page'), //any
                                            'post_status' => 'publish',
                                            'posts_per_page' => -1,
                                            'orderby' => 'title',
                                            'order' => 'ASC'
                                        );

                                        $the_query = new WP_Query( $args );

                                        if ( $the_query->have_posts() ) {

                                            while ( $the_query->have_posts() ) {
                                                $the_query->the_post();

                                                $newdata = array(
                                                    'id' => get_the_id(),
                                                    'term_id' => '',
                                                    'name' => get_the_title(),
                                                    'type' => 'page',
                                                    'disabled' => false
                                                );
                                                array_push($plksc_urls, $newdata);

                                            }

                                            wp_reset_postdata();
                                        }


                                        /**
                                         * post
                                         */
                                        $newdata =  array (
                                            'id' => '',
                                            'term_id' => '',
                                            'name' => __('--------- Post ----------', 'plksc'),
                                            'type' => '',
                                            'disabled' => true
                                        );
                                        array_push($plksc_urls, $newdata);

                                        $args = array(
                                            'post_type' => array('post'), //any
                                            'post_status' => 'publish',
                                            'posts_per_page' => -1,
                                            'orderby' => 'title',
                                            'order' => 'ASC'
                                        );

                                        $the_query = new WP_Query( $args );

                                        if ( $the_query->have_posts() ) {

                                            while ( $the_query->have_posts() ) {
                                                $the_query->the_post();

                                                $newdata = array(
                                                    'id' => get_the_id(),
                                                    'term_id' => '',
                                                    'name' => get_the_title(),
                                                    'type' => 'post',
                                                    'disabled' => false
                                                );
                                                array_push($plksc_urls, $newdata);

                                            }

                                            wp_reset_postdata();
                                        }
                                        ?>

                                        <select name="posts_list" class="toWatch" id="posts_list">
                                        <?php
                                        echo '<option></option>';

                                        foreach ($plksc_urls as $plksc_url) {
                                            $disabled = '';
                                            if($plksc_url['disabled'] == "true") {
                                                $disabled = 'disabled=""';
                                            }
                                            echo '<option 
                                            value="' . $plksc_url['id'] . '" 
                                            data-type="' . $plksc_url['type'] . '"
                                            ' .$disabled . '>' . $plksc_url['name'] . '</option>';
                                        }
                                        ?>
                                        </select>
                                        <label for="posts_list"><?php _e("", 'plksc' ); ?></label>
                                        <p class="description"><?php _e("", 'plksc' ); ?></p></td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php _e("Open in new window ?", 'plksc' ); ?></th>
                                    <td><input
                                            type="checkbox"
                                            id="open_new_window"
                                            name="open_new_window"
                                            class="toWatch"
                                            value="1">
                                        <label><?php _e("yes", 'plksc' ); ?></label>
                                        <p class="description"><?php _e("Check if you wish the link open in new window", 'plksc' ); ?></p></td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php _e("Shortcode generated", 'plksc' ); ?></th>
                                    <td id="shortcode_generated">[permalink]</td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td> <p class="description"><?php _e("Copy / Paste this shortcode where you wish to see your link", 'plksc' ); ?></p></td>
                                </tr>
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>

            <div id="top-sortables" class="meta-box-sortables ui-sortable"></div>
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                <div id="plksc_options" class="postbox">
                    <h2 class="hndle ui-sortable-handle"><span><?php _e('Frequently asked questions','plksc'); ?></span></h2>
                    <div class="inside">
                        <p><?php _e('Do you have questions about the plugin\'s operation?','plksc'); ?> <?php _e('Feel free to consult our frequently asked questions','plksc'); ?></p>
                        <table class="form-table" id="global">
                            <tbody>
                            <tr>
                                <th scope="row"><?php _e("What kind of post type, this plugin work with ?", 'plksc' ); ?></th>
                                <td>
                                    <p class="description"><?php _e("For now, our plugin works with post and page", 'plksc' ); ?></p></td>
                            </tr>

                            <tr>
                                <th scope="row"><?php _e("Can I use this plugin to generate shortcode for categories?", 'plksc' ); ?></th>
                                <td>
                                    <p class="description"><?php _e("Yes, our plugin works fine with categories, and tags as well.", 'plksc' ); ?></p></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

        <div id="postbox-container-1" class="postbox-container">
            <div id="priority_side-sortables" class="meta-box-sortables ui-sortable"></div>
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div id="itsec_get_backup" class="postbox ">
                    <h2 class="hndle ui-sortable-handle"><span><?php _e('Permalink shortcode','plksc'); ?></span></h2>
                    <div class="inside">
                        <p style="text-align: center;">
                            <img src="<?php echo PLKSC_URL; ?>admin/images/logo-128.png" alt=""></p>
                        <p><?php _e('With this plugin, once your shortcode is integrated inside your page, you can change the permalink\'s destination.','plksc'); ?></p>
                        <p><?php _e('once you have integrated the shortcode in your page, you can change the url of destination (permalink), your url will not be broken.', 'plksc'); ?></p>
                        <p><?php _e('No more 404 error !!', 'plksc'); ?></p>
                        <p><?php _e('To help you integrate the shorcode into your pages, you can use our shortcode generator.', 'plksc'); ?></p>
                        <p><?php _e('Once it generated, you just have to copy / paste to the desired place in your page.', 'plksc'); ?></p>
                        <p><?php _e('You can also embed the URLs of your tags and categories.', 'plksc'); ?></p>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- #post-body -->

</div>

</div>