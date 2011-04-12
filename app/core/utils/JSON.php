<?php
/**
 * Класс для работы с кодирования/декодирования данных в/из формат(а) JSON.
 *
 */
class JSON {


/**
 * Раскодирует данные из формата JSON
 *
 * @param unknown_type $data
 * @param boolean $asArray, указывает на необходимость вернуть данные в формате Array
 * @return возвращает раскодированные из формата JSON данные (в виде Std, Array)
 */
  static public function decode($data, $asArray = false) {
    return json_decode($data, $asArray);
  }


  /**
   * Кодирует данные в формат JSON, опционально с форматированием
   *
   * @param $data
   * @param boolean $format, - указывает, необходимо ли отформатировать данные для удобного просмотра
   * @return возвращает строку в формате JSON
   */
  static public function encode($data, $format = false) {
    return self::patch(($format) ? self::format(json_encode($data)) : json_encode($data));
  }


  /**
   * Форматирует строку JSON для приятного/наглядного просмотра
   *
   * @param строка в формате json
   * @return строку, отформатированную, тоже в формате JSON
   */
  static protected function format($json) {
    $tab = "  ";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;

    $json_obj = json_decode($json);

    if($json_obj === false)
      return false;

    $json = json_encode($json_obj);
    $len = strlen($json);

    for ($c = 0; $c < $len; $c++) {
      $char = $json[$c];
      switch($char) {
        case '{':
        case '[':
          if(!$in_string) {
            $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
            $indent_level++;
          }
          else {
            $new_json .= $char;
          }
          break;
        case '}':
        case ']':
          if(!$in_string) {
            $indent_level--;
            $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
          }
          else {
            $new_json .= $char;
          }
          break;
        case ',':
          if(!$in_string) {
            $new_json .= ",\n" . str_repeat($tab, $indent_level);
          }
          else {
            $new_json .= $char;
          }
          break;
        case ':':
          if(!$in_string) {
            $new_json .= ": ";
          }
          else {
            $new_json .= $char;
          }
          break;
        case '"':
          if($c > 0 && $json[$c-1] != '\\') {
            $in_string = !$in_string;
          }
        default:
          $new_json .= $char;
          break;
      }
    }

    return $new_json;
  }


  /**
   * Заменяет неправильно преобразуемые функциями json_encode/json_decode русские буквы на корректно понятные
   * в кодировке UTF-8
   *
   * @param unknown_type $string
   * @return unknown
   */
  static protected function patch($string) {
    return strtr($string, Array (
    '\u0430' => 'а',
    '\u0431' => 'б',
    '\u0432' => 'в',
    '\u0433' => 'г',
    '\u0434' => 'д',
    '\u0435' => 'е',
    '\u0451' => 'ё',
    '\u0436' => 'ж',
    '\u0437' => 'з',
    '\u0438' => 'и',
    '\u0439' => 'й',
    '\u043a' => 'к',
    '\u043b' => 'л',
    '\u043c' => 'м',
    '\u043d' => 'н',
    '\u043e' => 'о',
    '\u043f' => 'п',
    '\u0440' => 'р',
    '\u0441' => 'с',
    '\u0442' => 'т',
    '\u0443' => 'у',
    '\u0444' => 'ф',
    '\u0445' => 'х',
    '\u0446' => 'ц',
    '\u0447' => 'ч',
    '\u0448' => 'ш',
    '\u0449' => 'щ',
    '\u044c' => 'ь',
    '\u044b' => 'ы',
    '\u044a' => 'ъ',
    '\u044d' => 'э',
    '\u044e' => 'ю',
    '\u044f' => 'я',
    '\u0410' => 'А',
    '\u0411' => 'Б',
    '\u0412' => 'В',
    '\u0413' => 'Г',
    '\u0414' => 'Д',
    '\u0415' => 'Е',
    '\u0401' => 'Ё',
    '\u0416' => 'Ж',
    '\u0417' => 'З',
    '\u0418' => 'И',
    '\u0419' => 'Й',
    '\u041a' => 'К',
    '\u041b' => 'Л',
    '\u041c' => 'М',
    '\u041d' => 'Н',
    '\u041e' => 'О',
    '\u041f' => 'П',
    '\u0420' => 'Р',
    '\u0421' => 'С',
    '\u0422' => 'Т',
    '\u0423' => 'У',
    '\u0424' => 'Ф',
    '\u0425' => 'Х',
    '\u0426' => 'Ц',
    '\u0427' => 'Ч',
    '\u0428' => 'Ш',
    '\u0429' => 'Щ',
    '\u042c' => 'Ь',
    '\u042b' => 'Ы',
    '\u042a' => 'Ъ',
    '\u042d' => 'Э',
    '\u042e' => 'Ю',
    '\u042f' => 'Я'
    ));
  }


}