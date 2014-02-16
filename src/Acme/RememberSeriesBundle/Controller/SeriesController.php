<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\RememberSeriesBundle\Form\SeriesType;
use Symfony\Component\HttpFoundation\Request;
use Acme\RememberSeriesBundle\Entity\UserSeries;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class SeriesController extends Controller {

    public function getSecurityContext() {
        return $this->container->get('security.context');
    }

    public function getUser() {
        return $this->getSecurityContext()->getToken()->getUser();
    }

    public function seriesAction($series_id) {
        $params = array();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);

        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Series:series.html.twig', $params);
    }

    public function seriesListAction() {
        $params = array();

        $series = $this->getUser()->getSeriesList();

        $params['series'] = $series;

        $form = $this->createForm(new SeriesType(), new Series());
        $params['form'] = $form->createView();

        $response = $this->render('AcmeRememberSeriesBundle:Series:seriesList.html.twig', $params);
        return $response;
    }

    public function seriesListAllAction() {
        $params = array();

        $user = $this->getUser();

        $userSeries = $user->getSeriesList();

        $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
        $seriesQuery = $seriesRepository->createQueryBuilder('s')
                ->where('s.ownerId = 1 OR s.ownerId = :this_user')
                ->setParameter('this_user', $user)
                ->orderBy('s.name', 'ASC');

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

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);
        
        $userSeries = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserSeries')
                ->findOneBy(array('seriesId' => $series_id, 'userId' => $user->getId()));
         
        if (!$userSeries) {
            $userSeries = new UserSeries();
            $userSeries->setSeriesId($series);
            $em->persist($userSeries);

            $user->addSerie($userSeries);
        }

        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('_welcome'));
    }

    public function seriesCreateAction(Request $request) {

        $form = $this->createForm(new SeriesType(), new Series());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $series = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();

            $userSeries = new UserSeries();
            $userSeries->setuserId($user);
            $em->persist($userSeries);

            $series->addUser($userSeries);
            $series->setOwnerId($user);

            $em->persist($series);
            $em->flush();
        }

        return $this->forward('AcmeRememberSeriesBundle:Series:seriesList');
    }

    public function seriesRemoveAction($series_id) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserSeries')
                ->findOneBy(array('seriesId' => $series_id, 'userId' => $user->getId()));

        $user->removeSerie($series);

        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('_welcome'));
    }

    public function seriesSetWatchedAction($series_id, $is_watched) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserSeries')
                ->findOneBy(array('seriesId' => $series_id, 'userId' => $user->getId()));

        $series->setWatched($is_watched);

        $em->persist($series);
        $em->flush();

        return $this->redirect($this->generateUrl('_welcome'));
    }

}

