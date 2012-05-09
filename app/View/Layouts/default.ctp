<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? echo $title_for_layout; ?> | QME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <? echo $this->Html->css(array('base', 'home')); ?>
    <style type="text/css">
    body { padding-top: 60px; }
    </style>
    <? echo $this->Html->css(array('http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css')); ?>
    <? echo $this->fetch('css'); ?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<? echo $this->Html->url('/'); ?>">QME</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><? echo $this->Html->link('Content', '/content'); ?></li>
            </ul>
            <?
            if($user != null) {
              echo '<ul class="nav pull-right">';
              echo '<li class="divider-vertical"></li>';
              echo '</ul>';
            }
            ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <? echo $this->Session->flash(); ?>
      <? echo $this->fetch('content'); ?>

      <hr>

      <footer>
        <p>Copyright &copy; 2012 Stanford University. All Rights Reserved.</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?
    echo $this->Html->script(array(
      '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown',
      'bootstrap-scrollspy', 'bootstrap-tab', 'bootstrap-tooltip', 'bootstrap-popover',
      'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead',
      'base'
    ));
    echo $this->fetch('scripts');
    ?>   
  </body>
</html>