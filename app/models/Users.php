<?php
namespace App\Models;

use Core\Model;
use Core\Cookie;
use Core\Session;
use Core\Helpers;

use App\Models\UserSessions;
use App\Models\Users;

use Core\Validators\RequiredValidator;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\UniqueValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\FileExtensionValidator;
use Core\Validators\FileSizeValidator;


class Users extends Model {
  protected static $_table='users', $_softDelete = true;
  public static $currentLoggedInUser = null;
  
  // Table field as a method
  public $id, $username, $email, $password, $first_name, $last_name, $access_control_level,$deleted = 0, $confirm;

  public const blackListedFormKeys = ['id','deleted'];


  public function validator() {
    // Name Validator
    $this->runValidation(new RequiredValidator($this, ['field' => 'first_name',  'message' => 'First Name is required']));
    $this->runValidation(new RequiredValidator($this, ['field' => 'last_name',  'message' => 'Last Name is required']));

    // Email Validator
    $this->runValidation(new RequiredValidator($this, ['field' => 'email',  'message' => 'Email is required']));
    $this->runValidation(new EmailValidator($this, ['field' => 'email',  'message' => 'Email is not valid']));

    // Username Validator
    $this->runValidation(new MinValidator($this, [ 'field' => 'username', 'rule' => 6,  'message' => 'Username must be atleast 6 characters' ]));
    $this->runValidation(new MaxValidator($this, [ 'field' => 'username', 'rule' => 12,  'message' => 'Username cannot be more than 12 characters' ]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'username',  'message' => 'Username is required']));

    // Password Validator
    $this->runValidation(new RequiredValidator($this, ['field' => 'password',  'message' => 'Password cannot be empty ']));


    if ($this->isNew()) {
      $this->runValidation(new MatchesValidator($this, ['field' => 'password', 'rule' => $this->_confirmedPassword, 'message' => "Password should matches"]));
      $this->runValidation(new UniqueValidator($this, ['field' => 'username', 'message' => 'That username already exists, please choosse something else']));
      $this->runValidation(new MinValidator($this, [ 'field' => 'password', 'rule' => 6,  'message' => 'Password must be atleast 6 characters' ]));
      $this->runValidation(new MaxValidator($this, [ 'field' => 'password', 'rule' => 12,  'message' => 'Password cannot be more than 12 characters' ]));
    }

  }

  public function beforeSave() {
    //$this->timeStamps();
    if ($this->isNew()) {
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    } 
  }

  public static function findByUsername($username) {
    return self::findFirst(['conditions'=> "username = ?", 'bind'=>[$username]]);
  }


  public static function currentUser() {
    if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      self::$currentLoggedInUser = self::findById((int)Session::get(CURRENT_USER_SESSION_NAME));
    }
    return self::$currentLoggedInUser;
  }

  public function login($rememberMe = false) {
    Session::set(CURRENT_USER_SESSION_NAME, $this->id);
    if ($rememberMe) {
      $hash = md5(uniqid());
      $user_agent = Session::user_agent_no_version();
      Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = ['session' => $hash, "user_agent" => $user_agent, 'user_id' => $this->id];
      self::$_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
      self::$_db->insert("user_sessions", $fields);
    }
  }

  public static function loginUserFromCookie() {
    $user_session = UserSessions::getFromCookie();
    if ($user_session && $user_session->user_id != '') {
      $user = self::findById((int)$userSession->user_id);
      if ($user) {
        $user->login();
      }
    }
    return;
  }

  public function logout() {
    $userSession = UserSessions::getFromCookie();
    if ($userSession) $userSession->delete();
    Session::delete(CURRENT_USER_SESSION_NAME);
    if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
      Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$currentLoggedInUser = null;
    return true;
  }


  // Access Control Level
  
  public function acls() {
    if (empty($this->access_control_level)) return [];
    return json_decode($this->access_control_level, true);
  }

  public static function addAcl($user_id, $acl) {
    $user = self::findById($user_id);
    if (!$user) return false;
    $acls = $user->acls();
    if(!in_array($acl,$acls)){
      $acls[] = $acl;
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }

  public static function removeAcl($user_id, $acl){
    $user = self::findById($user_id);
    if(!$user) return false;
    $acls = $user->acls();
    if(in_array($acl,$acls)){
      $key = array_search($acl,$acls);
      unset($acls[$key]);
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }

  public function setConfirmedPassword($value) {
    $this->_confirmedPassword = $value;
  }

  public function getConfirmedPassword() {
    return $this->_confirmedPassword;
  }

  public function getUserId() {
    return $this->id;
  }

  public function displayFullName() {
    return $this->first_name . ' ' . $this->last_name;
  }

  public function isSuperAdmin() {
    return  (json_decode(self::currentUser()->access_control_level)[0] == "SuperAdmin");
  }


}


 ?>
