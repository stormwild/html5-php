<?php
namespace HTML5\Parser;

use \HTML5\Entities;

/**
 * Manage entity references.
 */
class CharacterReference {

  protected static $numeric_mask = array(0x0, 0x2FFFF, 0, 0xFFFF);

  /**
   * Given a name (e.g. 'amp'), lookup the UTF-8 character ('&')
   *
   * @param string $name
   *   The name to look up.
   * @return string
   *   The character sequence. In UTF-8 this may be more than one byte.
   */
  public static function lookupName($name) {
    // Do we really want to return NULL here? or FFFD
    return isset(Entities::$byName[$name]) ? Entities::$byName[$name] : NULL;
  }

  /**
   * Given a Unicode codepoint, return the UTF-8 character.
   *
   * (NOT USED ANYWHERE)
   */
  /*
  public static function lookupCode($codePoint) {
    return 'POINT';
  }
   */

  /**
   * Given a decimal number, return the UTF-8 character.
   */
  public static function lookupDecimal($int) {
    $entity = '&#' . $int . ';';
    // UNTESTED: This may fail on some planes. Couldn't find full documentation
    // on the value of the mask array.
    return mb_decode_numericentity($entity, self::$numeric_mask, 'utf-8');
  }

  /**
   * Given a hexidecimal number, return the UTF-8 character.
   */
  public static function lookupHex($hexdec) {
    return self::lookupDecimal(hexdec($hexdec));
  }
}
