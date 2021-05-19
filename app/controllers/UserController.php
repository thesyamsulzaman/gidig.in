<?
  namespace App\Controllers;

  use Core\Controller;
  use Core\Helpers;
  use Core\Router;
  use Core\FormHelpers;
  use Core\Session;

  use App\Models\Users;
  use App\Models\Login;


  class UserController extends Controller {
    public function onConstruct(){
      $this->view->setLayout('default');
    }

    public function loginAction() {
      $loginModel = new Login();

      if ($this->request->isPost()) {
        $this->request->csrfCheck();
        $loginModel->assign($this->request->get());
        $loginModel->validator();

        if ($loginModel->validationPassed()) {
          $user = Users::findByUsername($_POST['username']);

          if ($user && password_verify($this->request->get("password"), $user->password)) {
            $remember = $loginModel->getRememberMeChecked();
            $user->login($remember);
             Router::redirect('');
          } else if ($user && !password_verify($this->request->get("password"), $user->password)) {
            $loginModel->addErrorMessage('password', 'Wrong Password');
          } else {
            $loginModel->addErrorMessage('username', 'Username not found');
          }
        }
      }
      $this->view->login = $loginModel;
      $this->view->displayErrors = $loginModel->getErrorMessages();
      $this->view->render('user/login');
    }

    public function detailAction($user_id) {
      $user = Users::findById($user_id);
      $this->view->user = $user;
      $this->view->render('user/detail');
    }
    
    public function registerAction() {
      $newUser = new Users();

      if ($this->request->isPost()) {

        $this->request->csrfCheck();
        $newUser->assign($this->request->get());
        $newUser->setConfirmedPassword($this->request->get('confirm_password'));

        if ($newUser->save()) {
          Router::redirect("user/login");
        }     

      }
  
      $this->view->newUser = $newUser;
      $this->view->displayErrors = $newUser->getErrorMessages();

      $this->view->render('user/register');
  
    }

    public function logoutAction() {
      if (Users::currentUser()) {
        Users::currentUser()->logout();
      }
      Router::redirect("user/login");
    }



  }