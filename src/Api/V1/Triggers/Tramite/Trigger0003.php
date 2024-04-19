<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Triggers\Tramite;

use Exception;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Repository\UsuarioRepository;
use SuppCore\AdministrativoBackend\Triggers\TriggerInterface;

use SuppMB\MensagemBackend\Entity\Tramite as Entity;
use SuppMB\MensagemBackend\Api\V1\DTO\Tramite as TramiteDTO;
use SuppMB\MensagemBackend\Api\V1\Resource\TramiteFuturoResource;
use SuppMB\MensagemBackend\Api\V1\Resource\TramiteResource;

/**
 * Class Trigger0003.
 *
 * @descSwagger=Regras de negócio da action Encaminhar
 * @classeSwagger=Trigger0003
 */
class Trigger0003 implements TriggerInterface
{
    /**
     * Trigger0003 constructor.
     */
    public function __construct(private TramiteResource $tramiteResource, private TramiteFuturoResource $tramiteFuturoResource, private UsuarioRepository $usuarioRepository) {}

    public function supports(): array
    {
        return [
            TramiteDTO::class => [
                'afterEncaminhar'
            ],
        ];
    }

    /**
     * @param TramiteDTO|RestDtoInterface|null $restDto
     * @param Entity $entity
     * 
     * @throws Exception
     */
    public function execute(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): void
    {
        if (count($entity->getTramitesFuturos()) === 0) {throw new \DomainException("Não existe próximo no trâmite");}

        $idProximoUsuario = $entity->getProximoTramiteFuturo()->getUsuario()->getId();

        $proximoUsuario = $this->usuarioRepository->find($idProximoUsuario);

        $entity->setUsuarioAtual($proximoUsuario);

        $entity->getTramitesFuturos()->removeElement($entity->getProximoTramiteFuturo());
    }

    public function getOrder(): int
    {
        return 3;
    }
}
