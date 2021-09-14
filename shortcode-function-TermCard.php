<?php
    function Draw_TermCard() {
        $events = tribe_get_events();
 
        $num_of_days = 56;

        // Create an empty array to write events into
        $events_array = array_fill(0, $num_of_days, array());

        $start_date_object = null;

        foreach ( $events as $event ) {
            if ($event -> post_title == "Term Start") {
                $details = tribe_get_event($event);
                $start_date_object = $details -> start;
                break;        
            }
        }
        
        if ( start_date_object ) {
            
            // Extract all details and place them in events_array, which is ordered by day
            foreach ( $events as $event ) {
                $details = tribe_get_event($event);
                
                $event_date_object = $details -> start;

                $diff = $start_date_object -> diff($event_date_object);
                $days_diff = $diff -> days;

                //Check if the event happens in the current term before placing it in the array
                if (0 <= $days_diff && $days_diff < $num_of_days) {
                    $start_time = substr($details -> start_date, -8);
                    $end_time = substr($details -> end_date, -8);
                    $link = new SimpleXMLElement(tribe_get_event_website_link($event));
                    $categ = substr(strip_tags(tribe_get_event_categories($event -> ID)),16);
                    
                    $content = array("title" => $event -> post_title, "start_time" => $start_time, "end_time" => $end_time,
                    "category" => $categ, "link" => $link["href"]);

                    array_push($events_array[$days_diff], $content); 
                }

            }

            $html_output = "<figure class='wp-block-table alignfull'><table><tbody><tr><td></td><td>Sunday</td><td>Monday</td><td>Tuesday</td>
            <td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td>";

            //Generate html
            for ($i = 0; $i < $num_of_days; $i++) {
                
                if (i % 7 == 0) {
                    $html_output .= "</tr><tr>";
                }

                $html_output .= "<td>";

                foreach ( $events_array[i] as $event ) {
                    $html_output .= "<div name= \"$event['category']\"> <a href=\"$event['link']\">$event['title']</a> <br> 
                    ${event['start_time']}-$event['end_time']</div>";
                }

                $html_output .= "</td>";
            }
            
            $html_output .= "</tr></tbody></table></figure>";

        }
    }

    add_shortcode( 'TermCard', 'Draw_TermCard');

?>