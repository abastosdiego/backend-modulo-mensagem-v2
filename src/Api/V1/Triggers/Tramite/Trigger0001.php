<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Triggers\Tramite;

use Exception;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Repository\UsuarioRepository;
use SuppCore\AdministrativoBackend\Triggers\TriggerInterface;

use SuppMB\MensagemBackend\Api\V1\DTO\Tramite;
use SuppMB\MensagemBackend\Api\V1\DTO\TramiteFuturo;
use SuppMB\MensagemBackend\Api\V1\Resource\TramiteFuturoResource;
use SuppMB\MensagemBackend\Api\V1\Resource\TramiteResource;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class Trigger0001.
 *
 * @descSwagger=Informar aqui a descrição da Trigger!
 * @classeSwagger=Trigger0001
 */
class Trigger0001 implements TriggerInterface
{
    private $usuarioLogado;

    /**
     * Trigger0001 constructor.
     */
    public function __construct(private TramiteResource $tramiteResource, private TokenStorageInterface $tokenStorage) 
    {
        $this->usuarioLogado = $this->tokenStorage->getToken()->getUser();
    }

    public function supports(): array
    {
        return [
            Tramite::class => [
                'beforeCreate'
            ],
        ];
    }

    /**
     * @param Tramite|RestDtoInterface|null $restDto
     *
     * @throws Exception
     */
    public function execute(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): void
    {
        $restDto->setUsuarioAtual($this->usuarioLogado);
    }

    public function getOrder(): int
    {
        return 1;
    }
}
