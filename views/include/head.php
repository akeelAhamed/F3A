	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="language" content="English" />
	<meta name="theme-color" content="#c4eef1" />

	<?php if (isset($index)) : ?>
	    <meta http-equiv="Cache-control" content="public" />
	    <meta name="robots" content="index, follow" />
	<?php else : ?>
	    <meta name="robots" content="noindex, nofollow" />
	<?php endif; ?>
	<meta name="csrf" content="<?php getCsrf(true); ?>">
	<meta name="description" content="" />
	<title><?php $title = (isset($title)) ? $title. ' | ' : 'Welcome to ';
            echo $title . APP_NAME; ?></title>
	<meta name="keywords" content="" />
	<meta name="author" content="<?php echo APP_NAME; ?>" />
	<meta property="og:title" content="Welcome to <?php echo APP_NAME; ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo WEBSITE; ?>" />
	<meta property="og:image" content="<?php asset('images/logo-72x72.png'); ?>" />

	<link rel="icon" sizes="72x72" href="<?php asset('images/logo-72x72.png'); ?>" />
	<link rel="stylesheet" href="<?php asset('css/custom.css'); ?>" />

	<link rel="stylesheet" href="<?php asset('css/uikit.min.css'); ?>" />
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<link rel="stylesheet" href="<?php asset('css/style.css'); ?>" />
	<link rel="stylesheet" href="<?php asset('css/notyf.min.css'); ?>" />

    <?php
    if (isset($style)) :
        foreach ($style as $src) :
            ?>
	        <link rel="stylesheet" href="<?php asset($src); ?>"/>
	<?php
        endforeach;
    endif;
    ?>

	<style>
	    .logo img {
	        border-radius: 50%;
	        height: 75px;
	        width: 75px;
	        box-shadow: 0px 0px 9px rgba(0, 0, 0, 0.28);
	    }
		.lactive{
			color:#FFF !important;
		}
		.lactive::before{
			content: '';
			width: 20px;
			height: 2px;
			position: absolute;
			background: #1e87f0;
			margin-left: -25px;
    		margin-top: 11px;
		}
	</style>

	<?php /* Need <!DOCTYPE html> <html lang="en" prefix="og: http://ogp.me/"> <head>
     Common head to all page. Must include script.php at the bottom */ ?>