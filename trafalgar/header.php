<!doctype html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="header">
       <div class = "container">
           <div class = "inner_header">
           <a class="header-logo" href="/"><img src="<?= get_template_directory_uri()?>/images/logo.png" /></a>
               
           <ul class="header-menu">
                    <li class="is-active"><a href="#">Home</a></li>
                    <li><a href="#">Find a doctor</a></li>
                    <li><a href="#">Apps</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">About us</a></li>
                </ul>

               
           </div>
       </div>
    </div>