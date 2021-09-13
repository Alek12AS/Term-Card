<?php
    function Draw_TermCard() {
        $events = tribe_get_events();
 
        // Loop through the events, displaying the title and content for each
        foreach ( $events as $event ) {
            $details = tribe_get_event($event);
            $link = tribe_get_event_website_link($event);
            $a = new SimpleXMLElement($link);
            
            $obtain_categ = tribe_get_event_categories($event -> ID);
            
            $categ = substr(strip_tags($categ),16);

            

            

        }
    }

    add_shortcode( 'TermCard', 'Draw_TermCard');

?>