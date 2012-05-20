<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/', array('controller'=>'users', 'action'=>'dashboard'));
Router::connect('/models/:action/:short_name/*',
  array('controller'=>'qmodels'), array('pass'=>array('short_name')));
Router::connect('/models/:action/*', array('controller'=>'qmodels'));
Router::connect('/update_place/*', array('controller'=>'places', 'action'=>'update'));
Router::connect('/update_entity/*', array('controller'=>'entities', 'action'=>'update'));
Router::connect('/update_link/*', array('controller'=>'links', 'action'=>'update'));
Router::connect('/add_place/*', array('controller'=>'places', 'action'=>'create'));
Router::connect('/add_entity/*', array('controller'=>'entities', 'action'=>'create'));
Router::connect('/add_link/*', array('controller'=>'links', 'action'=>'create'));
Router::connect('/delete_place/*', array('controller'=>'places', 'action'=>'delete'));
Router::connect('/delete_entity/*', array('controller'=>'entity', 'action'=>'delete'));
Router::connect('/delete_link/*', array('controller'=>'links', 'action'=>'delete'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/:action/*', array('controller'=>'users'));


/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
