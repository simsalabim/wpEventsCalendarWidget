<?php

require_once dirname(__FILE__) . '/../core/ActiveRecord.php';

class Event extends ActiveRecord {

  protected $tableName = 'wp_events_calendar';

  public function __construct() {
    parent::__construct(dirname(__FILE__)  . '/../db.config');
  }
  
  public function find($conditions = array()) {
    $result = parent::find($conditions);
    foreach ($result as $key => $row) {
      foreach ($row as $field => $value) {
        if (in_array($field, array('title', 'description'))) {
          $result[$key][$field] = stripslashes(html_entity_decode($value));
        }
      }
    }
    return $result;
  }

  public function groupByDate() {
    $result = array();
    $events = $this->find();
    
    foreach ($events as $event) {
      $result[$event['date']][] = $event;
    }
    return $result;
  }
  

}