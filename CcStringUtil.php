<?php
/**
 * @copyright  Andreas Dirmeier (C) 2018
 *
 * This file is part of CcGitServer.
 *
 * CcGitServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CcGitServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with CcGitServer.  If not, see <http://www.gnu.org/licenses/>.
 **/
/**
 * @file      CcStringUtil.php
 * @author    Andreas Dirmeier
 * @par       Language: PHP
 *
 * Description for class CcStringUtil
 */
class CcStringUtil
{
  /**
   * Check if a string starts with specified string
   * @param string $haystack: String to search in
   * @param string $needle:   String to search for
   * @param string $bCaseSensitive: if false, case of strings will be ignored
   * @return boolean true if string is starting with
   */
  static public function startsWith ($haystack, $needle, $bCaseSensitive = true)
  {
    $length = strlen($needle);
    if ($length == 0)
    {
      return true;
    }
    if($bCaseSensitive)
      return (substr($haystack, 0, $length) === $needle);
    else
      return (strcasecmp(substr($haystack, 0, $length), $needle) == 0);
  }
  
  /**
   * Check if a string ends with specified string
   * @param string $haystack: String to search in
   * @param string $needle:   String to search for
   * @param string $bCaseSensitive: if false, case of strings will be ignored. default true;
   * @return boolean true if string is ending with
   */
  static public function endsWith ($haystack, $needle, $bCaseSensitive = true)
  {
    $length = strlen($needle);
    if ($length == 0)
    {
      return true;
    }
    if($bCaseSensitive)
    {
      return (substr($haystack, - $length) === $needle);
    }
    else
    {
      return (strcasecmp(substr($haystack, - $length), $needle) == 0);
    }
  }
  
  /**
   * Remove all matching characters from beginning of string
   * @param string $haystack: String to search in
   * @param string $needle:   String to search for
   * @param string $bCaseSensitive: if false, case of strings will be ignored. default true;
   * @return string shortened result
   */
  static public function removeAllLeading($haystack, $needle, $bCaseSensitive = true)
  {
    while (CcStringUtil::startsWith($haystack, $needle))
    {
      $haystack = substr($haystack, strlen($needle));
    }
    return $haystack;
  }
  
  /**
   * Remove all matching characters from ending of string
   * @param string $haystack: String to search in
   * @param string $needle:   String to search for
   * @param string $bCaseSensitive: if false, case of strings will be ignored. default true;
   * @return string shortened result
   */
  static public function removeAllEnding($haystack, $needle, $bCaseSensitive = true)
  {
    while (CcStringUtil::endsWith($haystack, $needle, $bCaseSensitive))
    {
      $haystack = substr($haystack, 0, -strlen($needle));
    }
    return $haystack;
  }
  
  /**
   * Clean a path by removing all .. and //
   * Example 
   *   /var/www/html/subdir//../subdir2//index.php -> /var/www/html/subdir2/index.php
   * @param string $sPath
   * @return string Cleaned path
   */
  static public function cleanPath($sPath)
  {
    $aPath = explode("/", $sPath);
    $aNewPath = array();
    $sLeading = "";
    if(isset($aPath[0]) && $aPath[0]=="")
    {
      // Path starts with path delimiter
      $sLeading = "/";
    }
    foreach ($aPath as $sPath)
    {
      switch ($sPath)
      {
        case "":
        case ".":
          // ignore
          break;
        case "..":
          if(count($aNewPath) > 0)
          {
            array_pop($aNewPath);
          }
          break;
        default:
          $aNewPath[] = $sPath;
      }
    }
    return $sLeading.implode("/", $aNewPath);
  }
  
  /**
   * @brief This method generates a string like var_dump will do
   * @param mixed $var: Variable to dump
   * @return string in vardump format
   */
  public static function getVarDump ($var)
  {
    ob_start();
    var_dump($var);
    $sData = ob_get_clean();
    return $sData;
  }
  
}