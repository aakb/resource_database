<?php

/*
 * This file is part of aakb/resource_database.
 *
 * (c) 2020 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace App\Controller;

use App\Entity\Resource;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resource")
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("/", name="resource_index", methods={"GET"})
     *
     * @param \App\Repository\ResourceRepository $resourceRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ResourceRepository $resourceRepository): Response
    {
        return $this->render('resource/index.html.twig', [
            'resources' => $resourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resource_new", methods={"GET","POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request): Response
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute('resource_index');
        }

        return $this->render('resource/new.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resource_show", methods={"GET"})
     *
     * @param \App\Entity\Resource $resource
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Resource $resource): Response
    {
        return $this->render('resource/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resource_edit", methods={"GET","POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Entity\Resource                      $resource
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Resource $resource): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resource_index');
        }

        return $this->render('resource/edit.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resource_delete", methods={"DELETE"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Entity\Resource                      $resource
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, Resource $resource): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resource_index');
    }
}
