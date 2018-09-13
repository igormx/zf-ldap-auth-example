<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 08:30 PM
 */

namespace AppAcl;


use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Rbac\Rbac;

class Module
{

    /**
     * @var Rbac
     */
    protected $rbacContainer;

    public function getConfig()
    {
        return include __DIR__."/../config/module.config.php";
    }


    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $eventManager=$mvcEvent->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE,array($this,'declareACL'),900);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH,array($this,'checkACL'),900);
    }


    public function declareACL(MvcEvent $mvcEvent)
    {
        $this->rbacContainer=new Rbac();

        $serviceManager=$mvcEvent->getApplication()->getServiceManager();
        $rbacConfiguration=$serviceManager->get('config')['rbac-permission'];

        foreach ($rbacConfiguration['roles'] as $role => $permissions) {
            $this->rbacContainer->addRole($role);
            foreach ($permissions as $permission) {
                $this->rbacContainer->getRole($role)->addPermission($permission);
            }
        }

        foreach ($rbacConfiguration['specificUsers'] as $user => $permissions) {
            $this->rbacContainer->addRole($user);
            foreach ($permissions as $permission) {
                $this->rbacContainer->getRole($user)->addPermission($permission);
            }
        }
    }

    public function checkACL(MvcEvent $mvcEvent)
    {
        $routeMatch=$mvcEvent->getRouteMatch();
        $routeName=$routeMatch->getMatchedRouteName();

        $sm=$mvcEvent->getApplication()->getServiceManager();

        /** @var AuthenticationService $backendAuthService */
        $backendAuthService=$sm->get(AuthenticationService::class);
        if($backendAuthService->hasIdentity()) {
            $identity=$backendAuthService->getIdentity();
            $dnParts=explode(",",$identity);
            $uid=str_replace("uid=","",$dnParts[0]);
            $ou=str_replace("ou=","",$dnParts[1]);

            if($this->rbacContainer->hasRole($uid)) {
                if(!$this->rbacContainer->isGranted($uid,$routeName)) {
                    $routeMatch->setParam('controller',"AppAcl\\Controller\\AclController");
                    $routeMatch->setParam('action',"noPermission");
                    $routeMatch->setMatchedRouteName('acl-no-permission');
                }
            } else {
                if (!$this->rbacContainer->isGranted($ou, $routeName)) {
                    $routeMatch->setParam('controller', "AppAcl\\Controller\\AclController");
                    $routeMatch->setParam('action', "noPermission");
                    $routeMatch->setMatchedRouteName('acl-no-permission');
                }
            }
        }
    }


}