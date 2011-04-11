<?php
/*
Plugin Name: Events Calendar Widget
Plugin URI: 
Description: 
Author: Alexander Kaupanin
Author URI: 
Version: 0.1
*/

require_once 'app/models/Event.php';

function my_first_widget($args) {
    extract($args);
   
    echo $before_widget;
    echo $before_title;
    echo get_option('my_widget_title'); 
    echo $after_title;
    
    $plugin_dir = basename(dirname(__FILE__));
?>

    <script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery.min.js"></script>
    
    <script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/jquery.ui.datepicker-ru.js"></script>
    <script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery-ui/ui-lightness/jquery-ui.css" />
    
    <script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery.cluetip/jquery.cluetip.js"></script>
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/vendor/jquery.cluetip/jquery.cluetip.css" />
    
    <script type="text/javascript" src="/wp-content/plugins/<?php echo $plugin_dir ?>/app/web/js/widget.js"></script>
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/<?php echo $plugin_dir ?>/app/web/css/styles.css" />

<?php
    echo '<div id="datepicker"></div>';
    echo $after_widget;
}


function register_my_widget() {
    register_sidebar_widget('Events Calendar Widget', 'my_first_widget');
    register_widget_control('Events Calendar Widget', 'my_widget_control' );
}


function my_widget_control() {
    if (! empty($_REQUEST['my_widget_title'])) {
        update_option('my_widget_title', $_REQUEST['my_widget_title']);
    }
    echo 'Заголовок&nbsp;:&nbsp;<input type="text" name="my_widget_title" />';
}



add_action('admin_menu', 'draw_menu');
add_action('init', 'register_my_widget');


// Function to deal with adding the calendar menus
function draw_menu() {
  $allowed_group = 'manage_options';
  add_menu_page(__('Calendar widget','calendar1'), __('Calendar widget','calendar1'), $allowed_group, 'calendar1', 'edit_events_calendar');
  add_submenu_page('calendar1', __('Manage Calendar Events','calendar1'), __('Manage Calendar Events','calendar1'), $allowed_group, 'calendar1', 'edit_events_calendar');

}


function edit_events_calendar() {
  require_once 'app/core/Template.php';
  $eventRecord = new Event();
  $tpl = new Template('views/table');
 
  if  ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
	$action = $data['action'];
	switch($action) {
	  case 'create': $eventRecord->create($data['event']); break;
	  case 'update': $eventRecord->update($data['id'], $data['event']); break;
	  case 'delete': 
	   $eventRecord->delete($data['event']);
	   break;
	  default: ;
	}
  }
  //global $current_user, $wpdb, $users_entries;
  $id = $_GET['id'];
  if ($id) {
    $event = $eventRecord->get($id);
	$tpl->assign(array(
      'event' => $event,
    ));
  }
  $action = $id ? 'update' : 'create';
 
  $events = $eventRecord->find(array('orderBy' => 'id'));
  $tpl->assign(array(
    'events' => $events,
	'plugin_dir' => basename(dirname(__FILE__)),
	'action' => $action
  ));
  $tpl->render();
}

