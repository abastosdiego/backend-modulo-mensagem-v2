<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Resource;

use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Rest\RestResource;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use SuppMB\MensagemBackend\Entity\Tramite as Entity;
use SuppMB\MensagemBackend\Api\V1\DTO\Tramite as TramiteDTO;
use SuppMB\MensagemBackend\Repository\TramiteRepository as Repository;

/**
 * Class TramiteResource.
 *
 * @method Repository  getRepository(): Repository
 * @method Entity[]    find(array $criteria = null, array $orderBy = null, int $limit = null, int $offset = null, array $search = null, array $populate = null): array
 * @method Entity|null findOne(int $id, bool $throwExceptionIfNotFound = null): ?EntityInterface
 * @method Entity|null findOneBy(array $criteria, array $orderBy = null, bool $throwExceptionIfNotFound = null): ?EntityInterface
 * @method Entity      create(RestDtoInterface $dto, string $transactionId, bool $skipValidation = null): EntityInterface
 * @method Entity      update(int $id, RestDtoInterface $dto, string $transactionId, bool $skipValidation = null): EntityInterface
 * @method Entity      delete(int $id, string $transactionId): EntityInterface
 * @method Entity      save(EntityInterface $entity, string $transactionId, bool $skipValidation = null): EntityInterface
 *
 * @codingStandardsIgnoreEnd
 */
class TramiteResource extends RestResource
{
    /** @noinspection MagicMethodsValidityInspection */

    public function __construct(
        Repository $repository,
        ValidatorInterface $validator
    ) {
        $this->setRepository($repository);
        $this->setValidator($validator);
        $this->setDtoClass(TramiteDTO::class);
    }


    /**
     * @param Processo|RestDtoInterface $dto
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws AnnotationException
     * @throws ReflectionException
     * @throws Exception
     */
    public function encaminhar(
        int $id,
        RestDtoInterface $dto,
        string $transactionId,
        ?bool $skipValidation = null
    ): EntityInterface {
        $skipValidation ??= false;

        // Fetch entity
        $entity = $this->getEntity($id);

        $restDto = $this->getDtoForEntity($id, get_class($dto), $dto);

        // $restDto->setUnidadeArquivistica(ProcessoEntity::UA_PROCESSO);

        // if (ProcessoEntity::UA_DOSSIE === $entity->getUnidadeArquivistica()) {
        //     $restDto->setTipoProtocolo(ProcessoEntity::TP_NOVO);
        // }

        // if (ProcessoEntity::UA_DOCUMENTO_AVULSO === $entity->getUnidadeArquivistica()) {
        //     $restDto->setTipoProtocolo(ProcessoEntity::TP_INFORMADO);
        // }

        // Validate DTO
        $this->validateDto($restDto, $skipValidation);

        // Before callback method call
        $this->beforeEncaminhar($id, $restDto, $entity, $transactionId);

        // Create or update entity
        $this->persistEntity($entity, $restDto, $transactionId);

        // After callback method call
        $this->afterEncaminhar($id, $restDto, $entity, $transactionId);

        return $entity;
    }

    public function beforeEncaminhar(
        int &$id,
        RestDtoInterface $dto,
        EntityInterface $entity,
        string $transactionId
    ): void {
        //$this->rulesManager->proccess($dto, $entity, $transactionId, 'assertAutuar');
        $this->triggersManager->proccess($dto, $entity, $transactionId, 'beforeEncaminhar');
        $this->rulesManager->proccess($dto, $entity, $transactionId, 'beforeEncaminhar');
    }

    public function afterEncaminhar(int &$id, RestDtoInterface $dto, EntityInterface $entity, string $transactionId): void
    {
        $this->triggersManager->proccess($dto, $entity, $transactionId, 'afterEncaminhar');
        $this->rulesManager->proccess($dto, $entity, $transactionId, 'afterEncaminhar');
    }
}
