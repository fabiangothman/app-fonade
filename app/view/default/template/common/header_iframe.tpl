<!doctype html>
<html>
<head>
<meta charset="<?php echo _CHARSET_; ?>">
<title><?php echo $title; ?></title>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<!--[if lt IE 9]>
	<script src="<?php echo _MSFW_PATH_._DEFAULT_VIEW_PATH_; ?>_js/polyFills/canvas/excanvas.js"></script>
<![endif]-->
<?php foreach ($jQueryScripts as $jQueryScript) { ?>
		<script src="<?php echo $jQueryScript['src']; ?>"></script>
    <?php
      if($jQueryScript['id'] != "$")
      {
    ?>
			<script type="text/javascript">
        var <?php echo $jQueryScript['id']; ?> = $.noConflict(true);
      </script>
    <?php  
      }
    ?>
	<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript"><!--
jQuery(document).ready(function(){
<?php foreach ($in_readyCodes as $in_readyCode) { ?>
<?php echo $in_readyCode; ?>
<?php } ?>
});
<?php foreach ($in_scripts as $in_script) { ?>
<?php echo $in_script; ?>
<?php } ?>
//--></script>

</head>

<body>
<div id="header"></div>

<div id="body">