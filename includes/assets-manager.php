<?php
/**
 * Apache License, Version 2.0
 * 
 * Copyright (C) 2018 Arman Afzal <rman.afzal@gmail.com>
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
 * 
 * 
 * Third Party Licenses :
 * 
 * tagEditor :
 * 
 * MIT License
 *
 * 
 * 
 * CodeMirror :
 * 
 * MIT License
 *
 * Copyright (C) 2017 by Marijn Haverbeke <marijnh@gmail.com> and others
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
 
 /**
 * @author Arman Afzal <rman.afzal@gmail.com>
 * @package WP_Divan_Control_Panel
 * @version 2.2.8
 */

if (!class_exists('WP_CI_Assets_Manager')) 
{

    class WP_CI_Assets_Manager
    {

        private $version;

        public static $codemirror_bundle = [
            'dcp-codemirror','dcp-codemirror-addon-fold','dcp-codemirror-addon-closebrackets',
            'dcp-codemirror-addon-matchbrackets','dcp-codemirror-addon-matchtags',
            'dcp-codemirror-addon-closetag','dcp-codemirror-addon-search',
            'dcp-codemirror-addon-fullscreen','dcp-codemirror-keymap',
            'dcp-codemirror-mode-xml','dcp-codemirror-mode-js',
            'dcp-codemirror-mode-css','dcp-codemirror-mode-htmlmixed',
            'dcp-codemirror-mode-clike', 'dcp-codemirror-mode-php'
        ];

        function __construct($version)
        {

            $this->version = $version;

            add_action( 'admin_enqueue_scripts', [$this , 'register_assets']);

        }



        function register_styles()
        {

            $ver = $this->version;

            // package-manager
            wp_register_style('package-manager' , plugins_url('assets/package-manager.css', __FILE__), [], $ver, 'all');

            // codemirror
            wp_register_style('dcp-codemirror', plugins_url('assets/codemirror/lib/codemirror.css', __FILE__), [], $ver, 'all');       
            wp_register_style('dcp-codemirror-dracula', plugins_url('assets/codemirror/theme/dracula.css', __FILE__), [], $ver, 'all');

            // tagEditor
            wp_register_style('dcp-tag-editor', plugins_url('assets/jquery.tag-editor.css', __FILE__), [], $ver, 'all');
            

        }



        function register_scripts()
        {

            $ver = $this->version;

            // package-manager
            wp_register_script('package-manager', plugins_url('assets/package-manager.js', __FILE__), ['jquery'], $ver, false);

            // codemirror
            wp_register_script('dcp-codemirror', plugins_url('assets/codemirror/lib/codemirror.js', __FILE__), ['jquery'], $ver, false);

            // codemirror > addons
            wp_register_script('dcp-codemirror-addon-fold', plugins_url('assets/codemirror/addons/fold/xml-fold.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-closebrackets', plugins_url('assets/codemirror/addons/edit/closebrackets.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-matchbrackets', plugins_url('assets/codemirror/addons/edit/matchbrackets.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-matchtags', plugins_url('assets/codemirror/addons/edit/matchtags.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-closetag', plugins_url('assets/codemirror/addons/edit/closetag.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-search', plugins_url('assets/codemirror/addons/search/match-highlighter.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-addon-fullscreen', plugins_url('assets/codemirror/addons/display/fullscreen.js', __FILE__), [], $ver, false);

            // codemirror > keymap
            wp_register_script('dcp-codemirror-keymap', plugins_url('assets/codemirror/keymap/sublime.js', __FILE__), [], $ver, false);

            // codemirror > mode
            wp_register_script('dcp-codemirror-mode-xml', plugins_url('assets/codemirror/mode/xml/xml.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-mode-js', plugins_url('assets/codemirror/mode/javascript/javascript.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-mode-css', plugins_url('assets/codemirror/mode/css/css.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-mode-htmlmixed', plugins_url('assets/codemirror/mode/htmlmixed/htmlmixed.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-mode-clike', plugins_url('assets/codemirror/mode/clike/clike.js', __FILE__), [], $ver, false);
            wp_register_script('dcp-codemirror-mode-php', plugins_url('assets/codemirror/mode/php/php.js', __FILE__), [], $ver, false);

            // tagEditor
            wp_register_script('dcp-caret', plugins_url('assets/jquery.caret.min.js', __FILE__), ['jquery'], $ver, false);
            wp_register_script('dcp-tag-editor', plugins_url('assets/jquery.tag-editor.min.js', __FILE__), ['jquery','dcp-caret'], $ver, false);


            wp_register_script('dcp-code-injection-editor', plugins_url('assets/code-editor.js', __FILE__), [], $ver, false);

        }



        function register_assets()
        {

            $this->register_styles();
            $this->register_scripts();

        }


    }

}