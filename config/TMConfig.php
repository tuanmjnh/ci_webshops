<?php

require_once('UUID.php');
//require_once('TMApplicationID.php');
require_once('TMLib.php');
//require_once('TMAccess.php');
require_once('TMPage.php');
require_once('TMINI.php');
//SET DEFAULT TIME ZONE
date_default_timezone_set('Asia/Ho_Chi_Minh');
//SET DEFAUTL URL
//define('TM_BASE_URL_BACKEND', TMUrl::TM_BASE_URL().'application/Backend');
//define('TM_BASE_URL_FRONTEND', TMUrl::TM_BASE_URL().'application/Frontend');
define('TM_ROOT_PATH_FRONTEND', TMUrl::root_path() . 'application/Frontend');
define('TM_ROOT_PATH_BACKEND', TMUrl::root_path() . 'application/Backend');
define('TM_BASE_URL', TMUrl::TM_BASE_URL());
define('TM_BASE_URL_Login', TMUrl::TM_BASE_URL() . 'login');
define('TM_BASE_URL_CMS', TMUrl::TM_BASE_URL() . 'cms');
define('TM_BASE_URL_CMS_Login', TMUrl::TM_BASE_URL() . 'cms/common/login');
define('TM_BASE_URL_Uploads', TMUrl::TM_BASE_URL() . 'Uploads/');
define('TM_BASE_URL_CMS_Error', TMUrl::TM_BASE_URL() . 'cms/error');
define('TM_SESSION_CMS', 'TM_DATA_CMS');
define('TM_SESSION', 'TM_DATA');

//SET APPLICATION ID
//define('TM_ApplicaionID', TMApplicationID::GetTMApplicationID());
