<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Controller;

use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SuppCore\AdministrativoBackend\Rest\Controller;
use SuppCore\AdministrativoBackend\Rest\ResponseHandler;
use SuppCore\AdministrativoBackend\Rest\Traits\Actions;
use Symfony\Component\Routing\Annotation\Route;

use SuppMB\MensagemBackend\Api\V1\Resource\TramiteResource;

#[Route(path: '/v1/tramite')]
#[Security("is_granted('IS_AUTHENTICATED_FULLY')")]
#[OA\Tag(name: 'Tramite')]
class TramiteController extends Controller
{
    // Traits
    use Actions\Colaborador\FindOneAction;
    use Actions\Colaborador\FindAction;
    use Actions\Colaborador\CreateAction;
    use Actions\Colaborador\UpdateAction;
    use Actions\Colaborador\PatchAction;
    use Actions\Colaborador\DeleteAction;
    use Actions\Colaborador\CountAction;

    public function __construct(
        TramiteResource $resource,
        ResponseHandler $responseHandler
    ) {
        $this->init($resource, $responseHandler);
    }

}
