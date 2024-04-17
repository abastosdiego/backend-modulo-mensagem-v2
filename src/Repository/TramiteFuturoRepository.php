<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Repository;

use SuppCore\AdministrativoBackend\Repository\BaseRepository;
use SuppMB\MensagemBackend\Entity\TramiteFuturo as Entity;

/**
 * Class TramiteFuturoRepository.
 *
 * @method Entity|null find(int $id, ?array $populate = null)
 * @method Entity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entity[]    findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 * @method Entity[]    findByAdvanced(array $criteria, array $orderBy = null, int $limit = null, int $offset = null, array $search = null): array
 * @method Entity[] findAll()
 */
class TramiteFuturoRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected static string $entityName = Entity::class;

}
