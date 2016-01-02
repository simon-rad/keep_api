<?php

namespace AppBundle\Controller;

use AppBundle\Repository\Note\LabelRepository;
use AppBundle\Repository\NoteRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends Controller
{
    /**
     * @Route("/note", name="note_get_all")
     * @Method("GET")
     */
    public function getAllAction()
    {
        /** @var NoteRepository $noteRepository */
        $noteRepository = $this->getDoctrine()->getManager()->getRepository(Note::class);
        $notes = $noteRepository->findAll();

        $notesDto = $this->get('serializer')->normalize($notes);

        return new JsonResponse($notesDto);
    }

    /**
     * @Route("/note", name="note_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var LabelRepository $labelRepository */
        $labelRepository = $em->getRepository(Note\Label::class);
        $labelsIds = array_column($payload['labels'], 'id');
        /** @var Note\Label[] $labels */
        $labels = $labelRepository->findById($labelsIds);
        /** @var Note $note */
        $note = $em->getRepository(Note::class)->createFromPayload($payload, $labels);

        $noteDto = $this->get('serializer')->normalize($note);

        return new JsonResponse($noteDto);
    }

    /**
     * @Route("/note/{id}", name="note_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, Note $note)
    {
        $payload = json_decode($request->getContent(),true);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var LabelRepository $labelRepository */
        $labelRepository = $em->getRepository(Note\Label::class);
        $labelsIds = array_column($payload['labels'], 'id');
        /** @var Note\Label[] $labels */
        $labels = $labelRepository->findById($labelsIds);
        /** @var Note $note */
        $updatedNote = $em->getRepository(Note::class)->updateFromPayload($note, $payload, $labels);

        $noteDto = $this->get('serializer')->normalize($updatedNote);

        return new JsonResponse($noteDto);
    }

    /**
     * @Route("/note/{id}", name="note_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Note $note)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($note);
        $em->flush();

        return new JsonResponse([]);
    }
}
