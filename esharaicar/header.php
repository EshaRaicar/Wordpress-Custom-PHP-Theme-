<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rio Island 🌴</title>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <?php wp_head(); ?>
</head>
<body>
    <header>
        <h1><a href="http://localhost/lab10/wordpress/"><?php bloginfo('name'); ?></a></h1>
        
        <?php wp_nav_menu(array('theme_location' => 'menu1')); ?>
        <h2 id="animation"> ❄️🎄Christmas Deal :<span style="color:green"> 30% Off! </span>🎄❄️</h2>
        

    </header>
<main>