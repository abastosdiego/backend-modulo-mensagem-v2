<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/mensagem')]
class MensagemController
{
    #[Route('/teste', name: 'index', methods: ['GET'])]
    public function teste(): Response
    {
        return new Response(
            '<html><body>valeu</body></html>'
        );
    }
}
