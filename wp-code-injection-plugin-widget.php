<?php

/**
 * Apache License, Version 2.0
 * 
 * Copyright (C) 2018 Arman Afzal <arman.afzal@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

if (!class_exists('Wp_Code_Injection_Plugin_Widget')) {


    class Wp_Code_Injection_Plugin_Widget extends WP_Widget
    {

        function __construct()
        {

            parent::__construct(
                'wp_code_injection_plugin_widget',
                __('Code Injection', 'wp-code-injection'),
                ['description' => __('Allows You to inject code snippets into the pages', 'wp-code-injection')]
            );

        }

        public function widget($args, $instance)
        {

            $title = apply_filters('widget_title', $instance['title']);

            if($title == '0')
            {
                return;
            }

            //output
            echo do_shortcode("[inject id='$title']");

        }

        public function form($instance)
        {

            if (isset($instance['title'])) {

                $title = $instance['title'];

            } else {

                $title = 'code-#########';

            }

            $query = new WP_Query([
                'post_type' => 'code',
                'post_status' => 'publish',
                'posts_per_page' => -1
            ]);
            
            ?>

             <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Code ID:' , 'wp-code-injection'); ?></label>
                <select style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>">
                <option value="0">— Select —</option>
            <?php

            while ($query->have_posts()) {

                $query->the_post();

                $post_title = get_the_title();

                ?>

                    <option <?php selected( $post_title , $title ) ?> value="<?php echo esc_attr($post_title); ?>" ><?php echo $post_title; ?></option>

                <?php
                
            }

            echo '</select></p>';

            wp_reset_query();
            
        }

        public function update($new_instance, $old_instance)
        {

            $instance = array();

            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

            return $instance;

        }

    }

}