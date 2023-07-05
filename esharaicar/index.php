<?php 

    get_header();

    if (is_home()){ 
        echo '<div id="history">';
        echo '<span id="welcome" >Welcome to Rio Island </span>, on this island you will find the most exquisite Villas to stay in. This private island hotel, has a limited number of Villas, just 5 private Villas on the entire island, basically the island is almost all yours! 
        We have the perfect Villas for each individual, either you are a couple planning to spend some time alone here, or a family with kids or a large group of friends and family, we have you covered. Each Villa is built with you in mind, from the best view and privacy, to the various number of other activities that the island offers such scuba diving, ziplining and many more.';
        echo '</div>';
    }

    if(have_posts() == true){
        echo '<div class="flex-container-post">';
        while(have_posts() == true){
            the_post();
            if (is_home()){ 
                echo '<div class="non_post_style">';
            }else{
                echo '<div id="post_style">';
            }
            
            get_template_part('template-parts/content-home');         
            get_template_part('template-parts/content-post');
            
            echo '</div>';
        }
        echo '</div>';
    }
    get_footer();

?>