<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Controller;

use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SuppCore\AdministrativoBackend\Annotation\RestApiDoc;
use SuppCore\AdministrativoBackend\Rest\Controller;
use SuppCore\AdministrativoBackend\Rest\RequestHandler;
use SuppCore\AdministrativoBackend\Rest\ResponseHandler;
use SuppCore\AdministrativoBackend\Rest\Traits\Actions;
use SuppCore\AdministrativoBackend\Transaction\Context;
use SuppMB\MensagemBackend\Api\V1\DTO\Tramite as TramiteDTO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SuppMB\MensagemBackend\Api\V1\Resource\TramiteResource;
use Throwable;

/**
 * @method TramiteResource getResource()
 */
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
    //use Actions\Colaborador\PatchAction;
    use Actions\Colaborador\DeleteAction;
    use Actions\Colaborador\CountAction;

    public function __construct(
        TramiteResource $resource,
        ResponseHandler $responseHandler
    ) {
        $this->init($resource, $responseHandler);
    }

    /**
     * Action customizada para encaminhar um tramite.
     *
     * @param string[]|null $allowedHttpMethods
     *
     * @throws LogicException
     * @throws Throwable
     * @throws HttpException
     * @throws MethodNotAllowedHttpException
     */
    #[Route(
        path: '/{id}/encaminhar',
        requirements: [
            'id' => '\d+',
        ],
        methods: ['PATCH']
    )]
    #[Security("is_granted('ROLE_COLABORADOR')")]
    #[RestApiDoc]
    public function encaminharAction(
        Request $request,
        int $id,
        ?array $allowedHttpMethods = null
    ): Response {
        $allowedHttpMethods ??= ['PATCH'];

        // Make sure that we have everything we need to make this work
        $this->validateRestMethod($request, $allowedHttpMethods);

        try {
            $transactionId = $this->transactionManager->begin();

            $context = RequestHandler::getContext($request);

            foreach ($context as $name => $value) {
                $this->transactionManager->addContext(
                    new Context($name, $value),
                    $transactionId
                );
            }

            $tramiteResource = $this->getResource();
            $tramiteDTO = $tramiteResource->getDtoForEntity($id, TramiteDTO::class);

            $tramiteEntity = $tramiteResource->encaminhar($id, $tramiteDTO, $transactionId, true);

            $this->transactionManager->commit($transactionId);

            return $this->getResponseHandler()->createResponse($request, $tramiteEntity);
        } catch (Throwable $exception) {
            throw $this->handleRestMethodException($exception, $id);
        }
    }

}
