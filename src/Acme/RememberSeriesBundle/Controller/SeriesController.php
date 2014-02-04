<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\RememberSeriesBundle\Form\SeriesType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class SeriesController extends Controller {

    public function seriesAction($series_id) {
        $params = array();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);
        $seasons = $series->getSeasons();

        $params['series'] = $series;
        $params['seasons'] = $seasons;

        return $this->render('AcmeRememberSeriesBundle:Series:series.html.twig', $params);
    }

    public function seriesListAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');

        $series = $securityContext->getToken()->getUser()->getSeries();
        $params['series'] = $series;

        $form = $this->createForm(new SeriesType(), new Series());
        $params['form'] = $form->createView();

        $response = $this->render('AcmeRememberSeriesBundle:Series:seriesList.html.twig', $params);

        return $response;
    }

    public function seriesListAllAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $userSeries = $user->getSeries()->toArray();

        $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
        $seriesQuery = $seriesRepository->createQueryBuilder('s')
                ->where('s.ownerId = 1 OR s.ownerId = :this_user')
                ->setParameter('this_user', $user);

        if (count($userSeries)) {
            $seriesQuery->andWhere('s.id NOT IN (:ids)')
                    ->setParameter('ids', $userSeries);
        }
        
        $series = $seriesQuery->getQuery()->getResult();

        $params['title'] = 'all series';
        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Series:seriesListAll.html.twig', $params);
    }

    public function seriesAddAction($series_id) {

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);

        $securityContext = $this->container->get('security.context');

        $user = $securityContext->getToken()->getUser();

        $user->addSeries($series);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_homepage'));
    }

    public function seriesCreateAction(Request $request) {

        $form = $this->createForm(new SeriesType(), new Series());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $series = $form->getData();


            $securityContext = $this->container->get('security.context');

            $user = $securityContext->getToken()->getUser();

            $series->addUser($user);
            $series->setOwnerId($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($series);
            $em->flush();
        }

        return $this->forward('AcmeRememberSeriesBundle:Series:seriesList');
    }

    public function seriesRemoveAction($series_id) {

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);

        $securityContext = $this->container->get('security.context');

        $user = $securityContext->getToken()->getUser();

        $user->removeSeries($series);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_homepage'));
    }

}

