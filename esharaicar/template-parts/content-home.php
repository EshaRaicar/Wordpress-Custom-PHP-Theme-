<?php
    if (is_home()){
        // echo '<div id="category">';
        // the_category(' | ');
        // echo '</div>';

        // echo'<div><a href="'.get_permalink() . '">';
        // the_post_thumbnail('thumbnail');
        // the_title('<h2>', '</h2>');
        // echo'</a></div>';

        // the_excerpt();

        echo'<div class="catergory_post"><a href="'.get_permalink() . '">';
        the_post_thumbnail('thumbnail');
        echo'</a>';
        // echo '<span style="align-content:justify;">';
        the_title('<h3>', '</h3>');
        // echo '</span>';

        echo '</div>';
    }
?>