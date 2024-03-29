<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Helpers;

class Login extends Model
{
  public $username, $password, $remember_me;
  protected static $_table = 'tmp_fake';

  public function validator()
  {
    $this->runValidation(new RequiredValidator($this, ['field' => 'username', 'message' => 'Username is required']));
    $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'message' => 'Password is required']));
  }

  public function getRememberMeChecked()
  {
    return ($this->remember_me === 'on');
  }
}
