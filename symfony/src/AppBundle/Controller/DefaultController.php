<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $query = $em->getRepository('AppBundle:Post')
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $posts = $this->get('knp_paginator')->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/post/{slug}", name="post_view")
     *
     * @param string $slug
     * @param EntityManagerInterface $em
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postDetail($slug, EntityManagerInterface $em, Request $request)
    {
        $post = $em->getRepository('AppBundle:Post')
            ->findOneBy(['slug' => $slug]);

        return $this->render('default/detail.html.twig', [
            'post' => $post,
        ]);
    }
}
