<? $js_includes = isset($js_includes) ? $js_includes : array(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?= $title ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="<?= SEEKING_MICHIGAN_HOST ?>/stylesheets/screen/main.css" type="text/css" media="screen, projection" />
  <!--[if IE]>
  <link rel="stylesheet" href="<?= SEEKING_MICHIGAN_HOST ?>/stylesheets/screen/patches/win-ie-all.css" type="text/css" media="screen, projection" />
  <![endif]-->
  <!--[if IE 7]>
  <link rel="stylesheet" href="<?= SEEKING_MICHIGAN_HOST ?>/stylesheets/screen/patches/win-ie7.css" type="text/css" media="screen, projection" />
  <![endif]-->
  <!--[if lt IE 7]>
  <link rel="stylesheet" href="<?= SEEKING_MICHIGAN_HOST ?>/stylesheets/screen/patches/win-ie-old.css" type="text/css" media="screen, projection" />
  <script type="text/javascript" src="<?= SEEKING_MICHIGAN_HOST ?>/js/lib/dd-png.js"></script>
  <![endif]-->
  <script type="text/javascript" src="<?= SEEKING_MICHIGAN_HOST ?>/js/core.js"></script>
  <script type="text/javascript" src="<?= SEEKING_MICHIGAN_HOST ?>/js/jquery.js"></script>
  <? foreach($js_includes as $js): ?>
    <? if(preg_match('/^http:\/\//',$js) > 0): ?>
      <script type="text/javascript" src="<?= $js ?>"></script>
    <? else: ?>
      <script type="text/javascript" src="<?= SEEKING_MICHIGAN_HOST ?>/js/<?= $js ?>.js"></script>
    <? endif; ?>
  <? endforeach; ?>
  <script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>
  <script type="text/javascript">
    try { _gat._getTracker("UA-7441223-2")._trackPageview(); } catch(err) {}
  </script>
  <? if(FACEBOX == 'display'): ?>
    <? include('include/facebox.php'); ?>
  <? endif; ?>
  <? if(LIGHTBOX == 'display'): ?>
    <? include('include/lightbox.php'); ?>
  <? endif; ?>
  <? if(SLIDER == 'display'): ?>
    <? include('include/slider.php'); ?>
  <? endif; ?>
</head>
<body id="www.seekingmichigan.com" class="<?= BODY_CLASS ?>">
  <div class="wrapper">
    <div id="header">
      <div class="wrapper">
        <h1><a href="<?= SEEKING_MICHIGAN_HOST ?>"><span><img src="<?= SEEKING_MICHIGAN_HOST ?>/images/governing-logo.gif" width="309" height="41" alt="Governing Michigan Logo" />Governing Michigan</span></a></h1>
        <ul id="nav">
          <li id="nav-seek"><a href="<?= SEEKING_MICHIGAN_HOST ?>/search"> Seek</a></li>
          <li id="nav-discover"><a href="<?= SEEKING_MICHIGAN_HOST ?>/discover"> Discover</a></li>
        </ul>
      </div>
    </div>
    <div id="main">
      <div class="wrapper mod">