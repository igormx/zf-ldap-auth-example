<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 07:21 PM
 */

namespace AppAuth\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Authentication\Adapter\Ldap;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AppAuthServiceFactory implements FactoryInterface
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
        $ldapOptions=$container->get('config')['ldap'];
        $ldapAdapter=new Ldap($ldapOptions);

        $authService =new AuthenticationService();
        $authService->setAdapter($ldapAdapter);
        return $authService;
    }
}