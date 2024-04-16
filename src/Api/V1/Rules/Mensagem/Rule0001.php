<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Rules\Mensagem;

use DateTime;
use Exception;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Rules\Exceptions\RuleException;
use SuppCore\AdministrativoBackend\Rules\RuleInterface;
use SuppCore\AdministrativoBackend\Rules\RulesTranslate;

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem as MensagemDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class Rule0001.
 *
 * @descSwagger=Verifica se a unidadeOrigem é uma Unidade
 * @classeSwagger=Rule0001
 *
 */
class Rule0001 implements RuleInterface
{
    public function __construct(private RulesTranslate $rulesTranslate) 
    {
    }

    public function supports(): array
    {
        return [
            MensagemDTO::class => [
                'beforeCreate',
            ],
        ];
    }

    /**
     * @param MensagemDTO|RestDtoInterface|null                       $restDto
     * @param \SuppMB\MensagemBackend\Entity\Mensagem|EntityInterface $entity
     *
     * @throws RuleException
     */
    public function validate(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): bool
    {
        if ($restDto->getUnidadeOrigem()->getParent() !== null) {
            $this->rulesTranslate->throwException('mensagem', '0001');
        }

        return true;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
