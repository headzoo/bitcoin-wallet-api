<?php
set_include_path(
  __DIR__ . "/../src" .
  PATH_SEPARATOR .
  get_include_path()
);
spl_autoload_register(function($class_name)
  {
    $class_name = ltrim($class_name, "\\");
    $file_name  = "";
    if ($pos_last = strrpos($class_name, "\\")) {
      $namespace  = substr($class_name, 0, $pos_last);
      $class_name = substr($class_name, $pos_last + 1);
      $file_name  = str_replace("\\", DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $file_name .= str_replace("_", DIRECTORY_SEPARATOR, $class_name) . ".php";

    require($file_name);
  });