<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 19.02.11
 * Time: 16:14
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

require_once 'utils/ArrayFu.php';

class ActiveRecord {

  protected $tableName;

  protected $lastInsertId = 0;

  public function __construct($pathToDbConfig = '') {
    if (file_exists($pathToDbConfig)) {
      require_once($pathToDbConfig);
    }
  }

 
  /**
   * Find entries by conditions
   *
   * @param array $conditions
   * @return array
   */   
  public function find($conditions = array()) {
    $conditions = $this->parseConditions($conditions);
    $where = '';
    foreach ($conditions['fields'] as $key => $field) {
       $where .= $field . '=' . $conditions['values'][$key];
       if ($field != ArrayFu::last($conditions['fields'])) {
         $where .= ' AND ';
      }      
    }
    $where = $where ? ' WHERE ' . $where : '';
	
    $sql = 'SELECT * FROM `' . $this->tableName . '` ' . $where . ' ' . $conditions['orderBy'] . ' ' . $conditions['limit'];
	
    $res = mysql_query($sql);
    $result = array();
    while ($row = mysql_fetch_assoc($res)) {
      $result[] = $row;
    }
    return $result;
  }


  /**
   * Get entry by id or other field (quick find)
   *
   * @param int $param  value of param to select
   * @param String $field  
   * @return boolean
   */  
  public function get($param, $field = 'id') {
    $conditions = array($field => $param);
    $item = $this->find($conditions);
    return ArrayFu::first($item);
  }


  /**
   * Сохранение записи
   *
   * @param array $record массив полей и значений записи
   * @return int id последней добавленной записи 
   */
  public function create($record) {
    $conditions = $this->parseConditions($record);
    $fields = implode(', ', $conditions['fields']);
    $values = implode(', ', $conditions['values']);

    $sql = 'INSERT INTO `' . $this->tableName . '` (' . $fields  . ') VALUES (' . $values . ')';
    mysql_query($sql);
    return $this->lastInsertId = mysql_insert_id();
  }
  

  /**
   * Update entry
   *
   * @param int $id  id of entry to update
   * @param array $record массив полей и значений записи
   * @return boolean
   */  
  public function update($id, $record) {
    $conditions = $this->parseConditions($record);
	
	$updateString = '';
	foreach ($conditions['fields'] as $key => $field) {
	  $updateString .= $field . '=' . $conditions['values'][$key];
	   if ($field != ArrayFu::last($conditions['fields'])) {
         $updateString .= ' , ';
       }      
	}

    $sql = 'UPDATE `' . $this->tableName . '` SET '  . $updateString .  '  WHERE `id`="' . $id . '"';
    mysql_query($sql);
    return $this->lastInsertId = mysql_insert_id();
  }

    
  /**
   * Delete entry
   *
   * @param array $record array of conditions
   * @return boolean
   */    
  public function delete($record) {
    $conditions = $this->parseConditions($record);
	$where = '';
	
	foreach ($conditions['fields'] as $key => $field) {
	  $where .= $field . '=' . $conditions['values'][$key];
	  if ($field != ArrayFu::last($conditions['fields'])) {
	    $where .= ' AND ';
	  }
	}
	
    $sql = 'DELETE FROM `' . $this->tableName . '` WHERE ' . $where;
    mysql_query($sql);
    return true;
  }


  /**
   * Распарсить массив входных условий для доступа к таблице
   * 
   * @param array $conditions
   * @return array
   */
  protected function parseConditions($conditions) {
    $orderBy = ArrayFu::get($conditions, 'orderBy', '');
    $orderBy = $orderBy ? ('ORDER BY ' . $orderBy) : '';
    unset($conditions['orderBy']);

    $limit = ArrayFu::get($conditions, 'orderBy', '');
    $limit = $limit ? ('LIMIT ' . $limit) : '';
    unset($conditions['limit']);

    $fields = array_map(array($this, 'backquote'), array_keys($conditions));
    $values = array_values($conditions);

    foreach($values as $key => $field) {
      if ($field == 'NULL') {
        $values[$key] = 'NULL';
      } else {
        $values[$key] = sprintf('\'%s\'', mysql_real_escape_string(htmlspecialchars($field)));
      }
    }
    return array('fields' => $fields, 'values' => $values, 'orderBy' => $orderBy, 'limit' => $limit);
  }

  
  /**
   * Заключить строку в обратные кавычки
   * @param string $string
   * @return string
   */
  protected function backquote($string) {
    return '`' . $string . '`';
  }


}
