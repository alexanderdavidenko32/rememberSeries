<?php

namespace Acme\RememberSeriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        $params = array();
        $params['movies'] = array(
            array(
                'name' => 'movie1',
                'text' => 'mv1'
            ),
            array(
                'name' => 'movie2',
                'text' => 'mv2'
            )
        );
        
//        $params['user'] = null;
        
//        $securityContext = $this->container->get('security.context');
//        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
////            var_dump($securityContext);die;
//            $params['user'] = $securityContext;
//            
//        }
//        $user = $this->container->get('fos_user.user_manager')->findUserByUserName('admin');
//        var_dump($user);die;

        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig', $params);
    }

    public function movieAction($name) {
        $params = array();
        $params['movie'] = $name;

        return $this->render('AcmeRememberSeriesBundle:Default:movie.html.twig', $params);
    }
}
