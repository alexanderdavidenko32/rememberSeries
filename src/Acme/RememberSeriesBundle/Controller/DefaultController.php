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

        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig', $params);
    }

    public function movieAction($name) {
        $params = array();
        $params['movie'] = $name;

        return $this->render('AcmeRememberSeriesBundle:Default:movie.html.twig', $params);
    }
}
