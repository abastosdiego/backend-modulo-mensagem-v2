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

/**
 * Class Trigger0002.
 *
 * @descSwagger=Informar aqui a descrição da Trigger!
 * @classeSwagger=Trigger0002
 */
class Trigger0002 implements TriggerInterface
{
    /**
     * Trigger0002 constructor.
     */
    public function __construct(private TramiteResource $tramiteResource, private TramiteFuturoResource $tramiteFuturoResource, private UsuarioRepository $usuarioRepository) {}

    public function supports(): array
    {
        return [
            Tramite::class => [
                'beforeCreate',
                'beforeUpdate'
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
        //dd($restDto);

        $idsUsuarios = explode(",", $restDto->getIdUsuariosTramitesFuturos());

        $ordem = count($idsUsuarios);

        foreach($idsUsuarios as $idUsuario) {

            $usuario = $this->usuarioRepository->find(intval($idUsuario));
        
            $tramiteFuturo = new TramiteFuturo();
            $tramiteFuturo->setOrdem($ordem);
            $tramiteFuturo->setTramite($entity);
            $tramiteFuturo->setUsuario($usuario);
            
            $this->tramiteFuturoResource->create($tramiteFuturo, $transactionId);

            $ordem--;
        }

    }

    public function getOrder(): int
    {
        return 2;
    }
}
