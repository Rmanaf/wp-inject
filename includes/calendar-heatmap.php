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
 */

if (!class_exists('WP_CI_Calendar_Heatmap')) {

    class WP_CI_Calendar_Heatmap
    {

        public $data = [];
        private $dowmap = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        function __construct()
        {
        }

        public function load($table_name, $id, $start, $end){

            global $wpdb;

            // get post title
            $post = get_post( $id );
            $id = $post->post_title;

            // convert dates to mysql format
            $start = $start->format('Y-m-d H:i:s');
            $end   = $end->format('Y-m-d H:i:s');


            $this->data = $wpdb->get_results(
                "SELECT time, WEEKDAY(time) weekday, HOUR(time) hour,
                COUNT(DISTINCT ip) unique_hits,
                COUNT(*) total_hits,
                SUM(case when error = '' then 0 else 1 end) total_errors
                FROM $table_name
                WHERE code='$id' AND (time BETWEEN '$start' AND '$end')
                GROUP BY hour"
            , ARRAY_A );

        }

        public function render(){

            $max = 10;

            if(count($this->data) > 0)
            {
                $max = max(array_map(function($item){   
                    return intval($item["unique_hits"]);
                }, $this->data )); 
            }

            if($max < 10)
            {
                $max = 10;
            }

            echo "<div class=\"gdcp-heatmap-container\">";

            foreach(range(0,6) as $weekday)
            {

                echo "<div class=\"gdcp-heatmap-row\">";

                if($weekday%2 != 0){
                    echo "<span class=\"dow\">{$this->dowmap[$weekday]}</span>";
                } else {
                    echo "<span class=\"dow\">&nbsp;</span>";
                }


                foreach(range(0,24) as $hour)
                {

                    $data = array_values(array_filter($this->data , function($dt) use ($weekday , $hour) {
                        return $dt['weekday'] == $weekday && $dt['hour'] == $hour;
                    }));
                
                    if(!empty($data)){

                        $hits = intval($data[0]["unique_hits"]);
                        
                        $plural = $hits > 1;

                        $color = self::get_color($hits , $max);

                        $time = date_i18n("M j, H:i", strtotime($data[0]["time"]));

                        ?>

                        <div class="gdcp-heatmap-cell" style="background-color: <?php echo $color; ?>;">
                            <p class="info">
                                <span><strong><?php echo $hits . ($plural ? " hits - " : " hit - "); ?></strong><span><span class="time"><?php echo $time; ?><span>
                                <i class="arrow-down"></i>
                            </p>
                        </div>

                        <?php

                    }else{

                        echo "<div class='gdcp-heatmap-cell'></div>";

                    }

                }

                echo "</div>";

            }

            echo "</div>";

        }

        public static function map(){

            $result = "<span class=\"gdcp-chart-colors\"><i>Less</i>";
            
            foreach(range(0,9) as $i){

                $color = self::get_color($i , 9);

                $result = $result . "<i class=\"gradient\" style=\"background-color: $color;\" ></i>";

            }
            
            $result = $result . "<i>More</i></span>";

            return $result;

        }

        private static function get_color($value , $max){

            $h = (1.0 - ($value / $max)) * 240;
            
            return "hsl(" . $h . ", 100%, 50%)";  
        }

    }

}
 