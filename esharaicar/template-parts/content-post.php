<?php
    if (is_single()){

        echo '<div class="content-post">';
        the_post_thumbnail('thumbnail');
        the_title('<h2>', '</h2>');
        the_content();
        the_tags();
        the_post_navigation(array(
            'prev_text'	=> __( '<span>Previous</span>: %title' ),
            'next_text'	=> __( 'Next: %title' )
        ));
        echo '</div>';
    }

?>

