<?php

namespace AppBundle\Controller;

use AppBundle\Repository\Note\LabelRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Note\Label;
use Symfony\Component\HttpFoundation\Request;

class LabelController extends Controller
{
    /**
     * @Route("/label", name="label_get_all")
     * @Method("GET")
     */
    public function getAllAction()
    {
        /** @var LabelRepository $labelRepository */
        $labelRepository = $this->getDoctrine()->getManager()->getRepository(Label::class);

        $labels = $labelRepository->findAll();
        $labelsDto = $this->get('serializer')->normalize($labels);

        return new JsonResponse($labelsDto);
    }

    /**
     * @Route("/label", name="label_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var LabelRepository $repository */
        $repository = $em->getRepository(Label::class);
        $payload = json_decode($request->getContent(), true);
        $label = $repository->createFromPayload($payload);

        $labelDto = $this->get('serializer')->normalize($label);

        return new JsonResponse($labelDto);
    }
    /**
     * @Route("/label/{id}", name="label_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, Label $label)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var LabelRepository $repository */
        $repository = $em->getRepository(Label::class);
        $payload = json_decode($request->getContent(), true);
        $label = $repository->updateFromPayload($label, $payload);

        $labelDto = $this->get('serializer')->normalize($label);

        return new JsonResponse($labelDto);
    }
    /**
     * @Route("/label/{id}", name="label_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Label $label)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($label);
        $em->flush();

        return new JsonResponse([]);
    }
}
