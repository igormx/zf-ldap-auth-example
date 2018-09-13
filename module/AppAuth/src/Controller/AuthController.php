<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 06:47 PM
 */

namespace AppAuth\Controller;


use AppAuth\Form\Login as LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    /**
     * @var LoginForm
     */
    protected $loginForm;

    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    public function __construct(LoginForm $loginForm, AuthenticationService $authenticationService)
    {
        $this->loginForm = $loginForm;
        $this->authenticationService = $authenticationService;
    }


    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost()->toArray();
            $this->loginForm->setData($postData);
            if ($this->loginForm->isValid()) {
                $validData = $this->loginForm->getData();

                $this->authenticationService->getAdapter()->setIdentity("uid={$validData['userName']},ou=Users,dc=zend,dc=com");
                $this->authenticationService->getAdapter()->setCredential($validData['password']);
                $authResult=$this->authenticationService->authenticate();
                if ($authResult->isValid()) {
                    $this->redirect()->toRoute('home');
                } else {
                    echo "error en la autenticacion!!!";
                    var_dump($authResult->getMessages());
                }
            } else {
                var_dump($this->loginForm->getMessages());
            }
        }

        return new ViewModel(['loginForm' => $this->loginForm]);
    }

}