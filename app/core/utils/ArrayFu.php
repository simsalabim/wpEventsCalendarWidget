<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 21:27
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class ArrayFu {


  /**
   * Получение значения(ключа) первого элемента массива
   * @param array $array Входной массив
   * @param boolean $return_key Вернуть ли ключ вместо значения
   * @return mixed $element(or $key) значение первого элемента входного массива (или его ключ, если $return_key = true)
   */
  public static function first($array, $return_key = false) {
    foreach ($array as $key => $element)
      return ($return_key ? $key : $array[$key]);
  }



  /**
   * Получение значения(ключа) последнего элемента массива
   * @param array $array Входной массив
   * @param boolean $return_key Вернуть ли ключ вместо значения
   * @return mixed $element(or $key) значение последнего элемента входного массива (или его ключ, если $return_key = true)
   */
  public static function last($array, $return_key = false) {
    $counter = 1;
    foreach ($array as $key => $element) {
      if ($counter == count($array))
        return ($return_key ? $key : $element);
      $counter++;
    }
  }


  /**
   * Получение значения элемента заданного массива с определённым индексом
   * @param array $array Входной массив
   * @param string $index Целевой индекс
   * @param [bool] $returning[optional] Возвращаемое значение в случае отсутствия заданного ключа
   * @return mixed Значение элемента входного массива с заданным мндексом или значение $returning в случае его отсутствия
   */
  public static function get($array, $index, $returning = false) {
    if (isset($array[$index]) && !empty($array[$index]))
      return $array[$index];
    return $returning;
  }

  
  /**
   * Получение значения действительного (!=== false) элемента заданного массива с определённым индексом
   * @param array $array Входной массив
   * @param string $index Целевой индекс
   * @param [bool] $returning[optional] Возвращаемое значение в случае отсутствия заданного ключа
   * @return mixed Значение элемента входного массива с заданным мндексом или значение $returning в случае его отсутствия
   */
  public static function getReal($array, $index, $returning = false) {
    if (isset($array[$index]) && $array[$index] !== false)
      return $array[$index];
    return $returning;
  }


  /**
   * Получение пары ключ-значение входного массива с заданным порядковым номером
   * @param array $array Входной массив
   * @param int $sequentive[optional] Порядковый номер искомого элемента
   * @return array('key' => $key, 'value' => $value) Ассоциативный массив с ключами 'key' и 'value', содержащими соответственно ключ и значение искомого элемента входного массива
   */
  public static function get_assoc_pair($array, $sequentive = 0) {
    $index = 0;
    foreach ($array as $key => $value) {
      if ($sequentive == $index)
        return array('key' => $key, 'value' => $value);
      $index++;
    }
    return false;
  }


  /**
   * Получить срез значений ключей массива
   *
   * @param array $array входной массив (array('age' => 23, 'experience' => 2), array('age' => 25, 'experience' => 1))
   * @param string $key название ключа, по которому нужно сделать срез, например 'experience'
   * @param array $returning какой массив вернуть в случае отстутствия искомого среза
   * @return array результирующий массив array(0 => 2, 1 => 1)
   */
  public static function getSubArray(array $array, $key, $returning = array()) {
    $result = array();
    foreach($array as $subarray) {
      $result[] = self::getReal($subarray, $key);
    }
    return $result ? $result : $returning;
  }


  /**
   * парсит http query в массив и помещается в 1 строке
   * @param string $httpQuery
   * @return array
   */
  public static function fromHttpQuery($httpQuery) {
    if (is_string($httpQuery)) {
      parse_str($httpQuery, $array);

      return $array;
    }

    return array();
  }




}
