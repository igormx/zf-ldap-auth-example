<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 6/09/18
 * Time: 08:57 PM
 */

namespace AppAuth;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $mvcEvent
     */
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $eventManager=$mvcEvent->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH,array($this,'checkBackendAuth'),1000);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__."/../config/module.config.php";
    }


    public function checkBackendAuth(MvcEvent $e)
    {
        $routeMatch=$e->getRouteMatch();
        $sm=$e->getApplication()->getServiceManager();

        /** @var AuthenticationService $backendAuthService */
        $backendAuthService=$sm->get(AuthenticationService::class);
        //&& $routeMatch->getParam('backendBitAuthCheck')===true
        if(!$backendAuthService->hasIdentity()) {
            $routeMatch->setParam('controller',"AppAuth\\Controller\\AuthController");
            $routeMatch->setParam('action',"login");
            $routeMatch->setMatchedRouteName('auth-login');
        } else {
            //echo "tu usaurio es:".$backendAuthService->getIdentity();
        }
    }
}