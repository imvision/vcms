<?php

/**
 * PHP Micro Templating
 */

namespace imvision;
class Template {
  public static function Render($tmpl, $data = array()) {
      extract($data);
      ob_start();
      if(file_exists($tmpl)) {
        include $tmpl;
      }

      return ob_get_clean();
  }
}


//Example usage
/*
include 'tmpl.php';
echo \imvision\Template::Render("content.html");
echo \imvision\Template::Render("content.html", $data_array);
*/
