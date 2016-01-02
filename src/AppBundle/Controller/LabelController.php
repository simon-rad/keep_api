<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class LabelController extends Controller
{

	/**
	 * @Route("/label", name="label_get_all")
	 * @Method("GET")
	 */
	public function getAllAction()
	{
		return new JsonResponse([]);
	}

	/**
	 * @Route("/label", name="label_create")
	 * @Method("POST")
	 */
	public function createAction()
	{
		return new JsonResponse([]);
	}
	/**
	 * @Route("/label/{id}", name="label_update")
	 * @Method("PUT")
	 */
	public function updateAction()
	{
		return new JsonResponse([]);
	}
	/**
	 * @Route("/label/{id}", name="label_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction()
	{
		return new JsonResponse([]);
	}
}
