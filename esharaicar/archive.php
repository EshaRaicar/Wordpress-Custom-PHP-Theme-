<?php 

    get_header();
    the_archive_title('<h2>','</h2>');

    if(have_posts() == true){
        echo '<div class="flex-container">';
        while(have_posts() == true){
            echo '<div>';
            the_post();           

            echo'<div class="catergory_post"><a href="'.get_permalink() . '">';
            the_post_thumbnail('thumbnail');
            echo'</a>';
            the_title('<h3>', '</h3>');

            echo '</div></div>';

        }
        echo '</div>';
    }

    get_footer();

?>