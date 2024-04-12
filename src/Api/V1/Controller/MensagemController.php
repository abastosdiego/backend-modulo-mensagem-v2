<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/mensagem')]
class MensagemController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return new Response(
            '<html><body>Hello World!</body></html>'
        );
    }
}
