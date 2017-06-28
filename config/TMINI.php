<?php

class TMINI {

    protected $ext = '.ini';

    public function get_ini_file($dir = '*') {
        $file_lang = $dir . $this->ext;
        return parse_ini_file($file_lang);
    }

    public static function get_be_ini($module_file = NULL, $language = 'vi-vn', $language_dir = 'language') {
        $language = "/$language/";
        $language_dir = "/$language_dir";
        $module_file = ($module_file == NULL || empty($module_file)) ? trim($_SERVER["REQUEST_URI"], '/cms') : $module_file;
        $ini = new TMINI();
        return $ini->get_ini_file(TM_ROOT_PATH_BACKEND . $language_dir . $language . $module_file);
        //return TM_ROOT_PATH_BACKEND . $lang_dir . $lang . trim($_SERVER["REQUEST_URI"], '/cms');
    }

    public static function get_fe_ini($module_file = NULL, $language = 'vi-vn', $language_dir = 'language') {
        $language = "/$language";
        $language_dir = "/$language_dir";
        $module_file = ($module_file == NULL || empty($module_file)) ? $_SERVER["REQUEST_URI"] : $module_file;
        $ini = new TMINI();
        return $ini->get_ini_file(TM_ROOT_PATH_FRONTEND . $lang_dir . $lang . $module_file);
    }

}
