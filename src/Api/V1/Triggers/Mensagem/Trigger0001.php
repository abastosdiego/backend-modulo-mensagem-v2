<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Triggers\Mensagem;

use Exception;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Triggers\TriggerInterface;

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem;
use SuppMB\MensagemBackend\Api\V1\Resource\MensagemResource;

/**
 * Class Trigger0001.
 *
 * @descSwagger=Informar aqui a descrição da Trigger!
 * @classeSwagger=Trigger0001
 */
class Trigger0001 implements TriggerInterface
{
    private MensagemResource $mensagemResource;

    /**
     * Trigger0001 constructor.
     */
    public function __construct(
        MensagemResource $mensagemResource
    ) {
        $this->mensagemResource = $mensagemResource;
    }

    public function supports(): array
    {
        return [
            Mensagem::class => [
                'beforeCreate'
            ],
        ];
    }

    /**
     * @param Mensagem|RestDtoInterface|null $restDto
     *
     * @throws Exception
     */
    public function execute(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): void
    {
        $restDto->setAssunto($restDto->getAssunto() . ' (Trigger)');
    }

    public function getOrder(): int
    {
        return 1;
    }
}
