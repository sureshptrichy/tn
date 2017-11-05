<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/* $headerLine = _('True North Group');
if (is_array($G->defaultProperty) && count($G->defaultProperty) > 0) {
	if ($currentUser->loggedin) {
		$headerLine = $G->defaultProperty['name'].' <img src="'.$G->defaultProperty['logo'].'" alt="'.$G->defaultProperty['name'].'" />';
	} else {
		$headerLine = _('True North Group');
	}
} */
$headerLine = '<img src="'.THEME_URL.'images/truenorth-logo.jpg" />';

$header_quotes = array();

$header_quotes[] = array('when you see someone putting on their BIG BOOTS <br/>you can be pretty sure that an ADVENTURE<br/>is going to happen', 'winnie the pooh');

$header_quotes[] = array('whether you think you can, <br/>or think you can’t, <br/>you\'re right.', 'henry ford');

$header_quotes[] = array('you can\'t depend on your eyes <br/>when your imagination is out of focus', 'mark twain');

$header_quotes[] = array('go confidently in the direction of your dreams', 'henry david thoreau');

$header_quotes[] = array('sometimes in the winds of change <br/>we find our true direction', 'unknown');

$header_quotes[] = array('find your horse. <br/>discover the direction the horse is going. <br/>ride the horse in that direction.', 'peter mcwilliams');

$header_quotes[] = array('you can never cross the ocean unless you have the <br/>courage to lose sight of the shore', 'christopher columbus');

$header_quotes[] = array('yeah, right, it\'s you know, it\'s glass, it\'s broken glass,<br/> you know? it sells well, as a matter of fact, you know?<br/> it\'s just broken glass, you know?', 'irwin mainway');

$header_quotes[] = array('it\'s a beautiful day, don\'t let it get away', 'U2');

$header_quotes[] = array('everything\'s got a moral, if only you can find it', 'alice in wonderland');

$header_quotes[] = array('a life is an experiment. <br/>the more experiments you make the better.', 'ralph waldo emerson');

$header_quotes[] = array('the most important decision in your life might be <br/>to take a small step in a new direction', 'unknown');

$header_quotes[] = array('my destination is no longer a place, <br/>but a new way of seeing', 'marcel proust');

$header_quotes[] = array('if life seems jolly rotten, there\'s something you\'ve forgotten!', 'monty python');

$header_quotes[] = array('the moment you doubt whether you can fly, <br/>you cease for ever to be able to do it.', 'peter pan');

$header_quotes[] = array('effort and courage are not enough <br/>without purpose and direction', 'john f kennedy');

$header_quotes[] = array('nothing is beneath you <br/>if it is in the direction of your life', 'ralph waldo emerson');

$header_quotes[] = array('we put a label on every bag that says, "Kid! Be careful - <br/>broken glass!" i mean, we sell Bag O\' Glass, Bag O\' Nails, <br/>Bag O\' Sulfuric Acid. they\'re decent toys.', 'irwin mainway');

$header_quotes[] = array('if you do not change direction, <br/>you may end up where you are heading', 'lao tzu');

$header_quotes[] = array('sometimes we get lost trying to find ourselves but <br/>sometimes it is only when we are lost <br/>that we find ourselves', 'unknown');

$header_quotes[] = array('the one thing that you have that nobody else has <br/>is you', 'unknown');

$header_quotes[] = array('weak people revenge. <br/>strong people forgive. <br/>intelligent people ignore.', 'unknown');

$header_quotes[] = array('finding some quiet time in your life, <br/>i think, <br/>is hugely important', 'mariel hemingway');

$header_quotes[] = array('change doesn\'t come in nickels and dimes <br/>it comes in dedication and sweat', 'toni sorenson');

$header_quotes[] = array('just because my path is different doesn\'t mean i\'m lost', 'unknown');

$header_quotes[] = array('don\'t stop believing’. hold on to that feelin\'.', 'journey');

$header_quotes[] = array('the best way to cheer yourself up <br/>is to try to cheer somebody else up.', 'mark twain');

$header_quotes[] = array('it is only with the heart that one can see rightly. <br/>what is essential is invisible to the eye.', 'the little prince');

$header_quotes[] = array('take control of your mind and meditate', 'black eyed peas');

$header_quotes[] = array('it feels good to be lost in the right direction', 'unknown');

$header_quotes[] = array('the secret of getting ahead is getting started', 'mark twain');

$header_quotes[] = array('devote yourself to an idea. go make it happen. <br/>struggle on it. overcome your fears. <br/>don\'t forget: this is your dream.', 'unknown');

$header_quotes[] = array('happiness is a direction, <br/>not a place', 'sydney j harris');

$header_quotes[] = array('if you want to find the right road,<br/>follow many paths', 'unknown');

$header_quotes[] = array('direction is so much more important than speed. <br/>many are going nowhere fast.', 'anonymous');

$header_quotes[] = array('in every life we have some trouble, but when you worry <br/>you make it double. don\'t worry, be happy.', 'bobby mcferrin');

$header_quotes[] = array('get up, stand up; don\'t give up the fight', 'bob marley');

$header_quotes[] = array('you may say I\'m a dreamer, <br/>but I\'m not the only one', 'john lennon');

$header_quotes[] = array('now, you listen here! <br/>he\'s not the messiah. <br/>he\'s a very naughty boy!', 'brian’s mother');

$header_quotes[] = array('get your facts first, and then you can distort them <br/>as much as you please', 'mark twain');

$header_quotes[] = array('when nothing goes right, <br/>go left', 'unknown');

$header_quotes[] = array('learn from the mistakes of others. you can never live <br/>long enough to make them all yourself.', 'groucho marx');

$header_quotes[] = array('be a fruit loop in a world full of cheerios', 'unknown');

$header_quotes[] = array('you have brains in your head and feet in your shoes, you <br/>can steer yourself in any direction you choose!', 'dr. seuss');

$header_quotes[] = array('think left and think right and think low and think high. oh, the things you can think of if only you try.', 'dr. seuss');

$header_quotes[] = array('clothes make the man. <br/>naked people have little or no influence on society.', 'mark twain');



?><!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js lt-ie9" lang="<?php echo LANG; ?>"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="<?php echo LANG; ?>"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo $pageTitle; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?php echo THEME_URL; ?>css/vendor/datepicker.<?php echo $revision; ?>.css" rel="stylesheet" media="screen">
	<link href="<?php echo THEME_URL; ?>css/vendor/font-awesome.min.<?php echo $revision; ?>.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href="<?php echo THEME_URL; ?>css/style.<?php echo $revision; ?>.css" rel="stylesheet">
	<?php if(($G->url->getUrlBit(0) == 'settings' AND $G->url->getUrlBit(1) == 'compiledforms') || ($G->url->getUrlBit(0) == 'performancereviews')){?>
	<link href="<?php echo THEME_URL; ?>css/review-print.<?php echo $revision; ?>.css" rel="stylesheet" media="print">
	<?php } else {?>
	<link href="<?php echo THEME_URL; ?>css/print.<?php echo $revision; ?>.css" rel="stylesheet" media="print">
	<?php }?>
	<script src="<?php echo THEME_URL; ?>js/vendor/modernizr-2.6.2.min.js"></script>
	<script>
		var URL = '<?php echo URL; ?>';
		var baseDir = '<?php echo str_replace('/', "", URL); ?>';
		if(baseDir != '') {
			baseDir += '-'; 
		}
	</script>
	<!--[if lt IE 9]>
	<script src="<?php echo THEME_URL; ?>js/vendor/respond.min.<?php echo $revision; ?>.js"></script>
	<![endif]-->
	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="<?php echo THEME_URL; ?>js/main-new.<?php echo $revision; ?>.js"></script>
	
	
</head>
<body class="<?php echo $bodyClass; ?>">
<!--[if lt IE 9]>
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="alert-link">upgrade your browser</a> to improve your experience.
</div>
<![endif]-->
<div id="wrap" class="container">

						

	<div class="visible-print">
		<img class="tn-logo" src="<?php echo THEME_URL;?>images/truenorth-logo.jpg" />
		<img class="tn-banner" src="<?php echo THEME_URL;?>images/print-banner.jpg"/>
		<?php if($G->controller == 'strategiestactics') { ?>
		<?php $monthYear = date("F Y", strtotime(session('year') . '-' . session('month') . '-01')); ?>
		<h1 class="tn-page-title"  ><?php echo $G->user->firstname . ' ' . $G->user->lastname . ' ' . $monthYear; ?> TNOs</h1>
		<?php } ?>
	</div>
	<?php
	if ($showPageNav) {
		?>
		<a class="sr-only" href="#wrap">Skip to content</a>
		<div id="main-nav-wrapper" class="row" style="margin-right:0;">
			<div class="col-md-10 col-md-offset-1">

</div>
<div class="col-md-10 col-md-offset-1">

			
			
				<nav id="main-nav" class="navbar navbar-default" role="navigation">
					<div class="navbar-header clearfix">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex3-collapse">
							<span class="sr-only">Toggle Range</span>
							<span class="fa fa-bars"></span>
						</button>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-bars"></span>
						</button>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle Location</span>
							<span class="fa fa-bars"></span>
						</button>
						<a class="navbar-brand" href="<?php echo URL; ?>"><?php echo $headerLine; ?></a>
						<div style="float:right" class="header-quotes">
						
							<div class="cycle-slideshow" data-cycle-timeout="10000" data-cycle-slides="> div">
							<?php foreach ($header_quotes as $quote) { ?>
							<div>
							<p><?php echo $quote[0]; ?></p>
							<span>- <?php echo $quote[1]; ?></span>
							</div>
							<?php } ?>
							</div>
							
						</div>
					</div>
					<div class="nav-stick">
						<div class="collapse navbar-collapse navbar-ex1-collapse navbar-menu navbar-menu-location">
							<?php echo $sidebarSelector; ?>
						</div>
						<div class="collapse navbar-collapse navbar-ex2-collapse navbar-menu navbar-menu-pages">
							<?php echo $mainMenu; ?>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<!--<div id="main-breadcrumb-wrapper">
			<?php //echo $breadcrumbSelector; ?>
		</div>-->
	<?php
	}
	?>
	<div class="row">
	<?php
	if (is_array($flash)) {
		foreach ($flash as $type => $messages) {
			if (count($messages) > 0) {
				foreach ($messages as $message) { ?>
					<div class="col-md-10 col-md-offset-1 alert alert-<?php echo $type; ?> alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $message; ?>
					</div>
				<?php }
			}
		}
	}
	?>
		<?php /*if ($showPageNav) {
			?><div class="col-md-3">
			<div id="side-nav">
				<?php //echo $sidebarSelector; ?>
				<?php //echo $mainSidebar; ?>
			</div>
			</div><?php
		}*/ ?>
		<?php if ($showPageNav) {
			?><div class="col-md-10 col-md-offset-1 body-content"><?php
		} else {
			?><div class="col-md-10 col-md-offset-1 body-content"><?php
		} ?>
	<?php /*
	<header class="page-header" id="page-title">
		<h1><?php echo $pageTitle; ?> <small><?php //echo $headerLine; ?></small></h1>
	</header>
	*/?>
