<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mdl_login extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->model('login/Logged');
    }

    private $get_tblUsers = 'users';
    private $get_Access = 'TM_ACE';
    private $get_Account = 'TM_ACC';
    private $get_Session = '_session';
    private $get_Cookie = '_cookie';
    private $Authencation = 'Authencation';

//    function get_tblUsers() {
//        return "users";
//    }
//
//    function get_Access() {
//        return "TM_ACE";
//    }
//
//    function get_Account() {
//        return "TM_ACC";
//    }
//
//    function get_Session() {
//        return "_session";
//    }
//
//    function get_Cookie() {
//        return "_cookie";
//    }

    function _logging($data) {
        $query = $this->db->get_where($this->get_tblUsers, array(
                    'UVAccount' => $data['username']))->row();
        if ($query) {
            $query = $this->db->get_where($this->get_tblUsers, array(
                        'UVAccount' => $data['username'],
                        'UVPassword' => UUID::TMMD5($data['password'] . $query->UVPasswordSalt)))->row();
            if ($query) {
                $ac_code = '';
                if (!isset($data['remember']))
                    $ac_code = $this->login($this->get_Session, $data['username'], $query);
                else
                    $ac_code = $this->login($this->get_Cookie, $data['username'], $query);
                $this->db->where(array('UVID' => $query->UVID))
                        ->update($this->get_tblUsers, array(
                            'UDLastLogin' => TMLib::getNow(),
                            'UILoginTime' => 0,
                            'UVAccess' => $ac_code,
                            'UVLastInf' => 'ip,' . TMIP::IPClient() . '|' . 'mac,' . TMIP::MACClient()));
                return 3;
            } else
                return 2;
        } else
            return 1;
    }

    function login($type, $acc, $inf) {
        try {
            $value = UUID::TMMD5(UUID::NewGuid() . '-' . time());
            if ($type == $this->get_Session) {
                $_SESSION[$this->Authencation] = array($this->get_Account => $acc);
                $_SESSION[$this->Authencation] += array($this->get_Access => $value);
            } else {
                setcookie($this->Authencation, json_encode(array($this->get_Account => $acc, $this->get_Access => $value)), time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $this->set_users($inf);
            return $value;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function logout() {
        try {
            if (isset($_COOKIE[$this->Authencation])) {
                unset($_COOKIE[$this->Authencation]);
                setcookie($this->Authencation, '', time() - 3600, '/');
            }
            if (isset($_SESSION[$this->Authencation])) {
                unset($_SESSION[$this->Authencation]);
            }
            unset($_SESSION[$this->get_tblUsers]);
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function is_login() {
        try {
            if (isset($_COOKIE[$this->Authencation]))
                return TRUE;
            else if (isset($_SESSION[$this->Authencation]))
                return TRUE;
            else
                return FALSE;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function get_type_login() {
        try {
            if (isset($_COOKIE[$this->Authencation]))
                return $this->get_Cookie;
            else if (isset($_SESSION[$this->Authencation]))
                return $this->get_Session;
            else
                return NULL;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function get_access_code() {
        try {
            if (isset($_COOKIE[$this->Authencation]))
                return json_decode($_COOKIE[$this->Authencation])->TM_ACE;
            else if (isset($_SESSION[$this->Authencation][$this->get_Access]))
                return $_SESSION[$this->Authencation][$this->get_Access];
            else
                return NULL;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function get_acc_code() {
        try {
            if (isset($_COOKIE[$this->Authencation]))
                return json_decode($_COOKIE[$this->Authencation])->TM_ACC;
            else if (isset($_SESSION[$this->Authencation][$this->get_Account]))
                return $_SESSION[$this->Authencation][$this->get_Account];
            else
                return NULL;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function set_users($data = NULL, $session = NULL) {
        $session = $session ? NULL : $this->get_tblUsers;
        $_SESSION[$session] = $data;
    }

//    function users($user = $this->Authencation) {
//        if ($this->is_login()) {
//            if ($this->session->userdata($user) == NULL) {
//                $query = $this->db->get_where($this->get_tblUsers(), array(
//                            'UVAccount' => $this->get_acc_code(),
//                            'UVAccess' => $this->get_access_code()))->row();
//                if ($query)
//                    $this->set_users($query);
//                else
//                    $this->logout();
//            }
//            return $this->session->userdata($user);
//        } else
//            return NULL;
//    }
    function users($session = NULL) {
        $session = $session ? NULL : $this->get_tblUsers;
        if ($this->session->userdata($session) == NULL) {
            return $this->users_reset();
        }
    }

    function users_reset($session = NULL) {
        $session = $session ? NULL : $this->get_tblUsers;
        if ($this->is_login()) {
            $query = $this->db->get_where($this->get_tblUsers, array(
                        'UVAccount' => $this->get_acc_code(),
                        'UVAccess' => $this->get_access_code()))->row();
            if ($query)
                $this->set_users($query);
            else
                $this->logout();
            return $this->session->userdata($session);
        }
        return NULL;
    }

    function redirect_login() {
        if (!$this->is_login())
            redirect(TMUrl::return_login());
    }

    function redirect_continue() {
        if ($this->is_login())
            redirect(TMUrl::return_continue());
    }

    function return_continue() {
        if ($this->is_login())
            return TMUrl::return_continue();
    }

    function return_login() {
        return TMUrl::return_login();
    }

}

class Logged {

    public static function UserID() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVID;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function roles() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVRoles;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function username() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVAccount;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function password() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVPassword;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function password_salt() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVPasswordSalt;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function full_name() {
        try {
            if (isset($_SESSION[$this->Authencation]) && $_SESSION[$this->Authencation]->UVProperty_names != NULL) {
                $name = TMLib::SplitTrim($_SESSION[$this->Authencation]->UVProperty_names);
                return $name[0] . ' ' . $name[1];
            }
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function first_name() {
        try {
            if (isset($_SESSION[$this->Authencation]) && $_SESSION[$this->Authencation]->UVProperty_names != NULL) {
                $name = TMLib::SplitTrim($_SESSION[$this->Authencation]->UVProperty_names);
                return $name[0];
            }
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function last_name() {
        try {
            if (isset($_SESSION[$this->Authencation]) && $_SESSION[$this->Authencation]->UVProperty_names != NULL) {
                $name = TMLib::SplitTrim($_SESSION[$this->Authencation]->UVProperty_names);
                return $name[1];
            }
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function email() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVEmail;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function mobile() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVMobile;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function picture($size = '64') {
        try {
            if (isset($_SESSION[$this->Authencation]) && $_SESSION[$this->Authencation]->UVPicture != NULL && $_SESSION[$this->Authencation]->UVPicture != '')
                return TM_BASE_URL . $_SESSION[$this->Authencation]->UVPicture;
            return TM_BASE_URL . "assets/images/user_df_$size.png";
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function access() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVAccess;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function last_inf() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::SplitStr($_SESSION[$this->Authencation]->UVLastInf);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function create_date() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::FormatDate2($_SESSION[$this->Authencation]->UDCDate);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function update_date() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::FormatDate2($_SESSION[$this->Authencation]->UDUDate);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function last_login() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::FormatDate2($_SESSION[$this->Authencation]->UDLastLogin);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function last_change_password() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::FormatDate2($_SESSION[$this->Authencation]->UDlastChangePass);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function locked() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UDLocked == 1 ? FALSE : TRUE;;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function locked_by() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return $_SESSION[$this->Authencation]->UVLockedBy;
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

    public static function locked_date() {
        try {
            if (isset($_SESSION[$this->Authencation]))
                return TMLib::FormatDate2($_SESSION[$this->Authencation]->UDLockedDate);
            return NULL;
        } catch (Exception $exc) {
            return NULL;
        }
    }

}
