<?php

namespace AppBundle\EventListener;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class KernelExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent  $event)
    {
        $request = $event->getRequest();

        if ($this->isRequestAcceptsJson($request))
        {
            $exception = $event->getException();

            $response = new JsonResponse([
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
                'code' => $exception->getCode()
            ]);

            $event->setResponse($response);
        }

        if ($this->isRequestFromTests($request))
        {
            $exception = $event->getException();

            $output = new BufferedOutput(
                OutputInterface::VERBOSITY_VERBOSE,
                true
            );

            $output->writeln($exception->getMessage());
            $output->writeln($exception->getCode());
            $output->writeln($exception->getTraceAsString());

            $response = new Response($output->fetch());

            $event->setResponse($response);
        }
    }

    private function isRequestAcceptsJson(Request $request)
    {
        return $request->headers->contains('Accept', 'application/json');
    }

    private function isRequestFromTests(Request $request)
    {
        return $request->headers->contains('Accept', 'console/output');
    }
}