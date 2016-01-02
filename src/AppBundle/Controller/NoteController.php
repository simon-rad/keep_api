<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class NoteController extends Controller
{

	/**
	 * @Route("/note", name="note_get_all")
	 * @Method("GET")
	 */
	public function getAllAction()
	{
		return new JsonResponse([]);
	}

	/**
	 * @Route("/note", name="note_create")
	 * @Method("POST")
	 */
	public function createAction()
	{
		return new JsonResponse([]);
	}
	/**
	 * @Route("/note/{id}", name="note_update")
	 * @Method("PUT")
	 */
	public function updateAction()
	{
		return new JsonResponse([]);
	}
	/**
	 * @Route("/note/{id}", name="note_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction()
	{
		return new JsonResponse([]);
	}
}
