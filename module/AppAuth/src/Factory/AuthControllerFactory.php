<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 06:49 PM
 */

namespace AppAuth\Factory;


use AppAuth\Controller\AuthController;
use AppAuth\Form\Login;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $loginForm=$container->get(Login::class);
        $authService=$container->get(AuthenticationService::class);
        $authController=new AuthController($loginForm,$authService);
        return $authController;
    }
}