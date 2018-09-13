<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 06:39 PM
 */

namespace AppAuth\Form;


use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class Login extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $userName=new Text('userName');
        $userName->setLabel('Nombre de Usuario');
        $this->add($userName);

        $password=new Password('password');
        $password->setLabel("Contraseña");
        $this->add($password);

        $submit=new Submit('submit');
        $submit->setValue('Enviar');
        $this->add($submit);
    }
}