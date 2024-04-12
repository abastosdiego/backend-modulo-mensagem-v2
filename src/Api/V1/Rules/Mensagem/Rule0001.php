<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Rules\Mensagem;

use DateTime;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Rules\Exceptions\RuleException;
use SuppCore\AdministrativoBackend\Rules\RuleInterface;
use SuppCore\AdministrativoBackend\Rules\RulesTranslate;

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem as MensagemDTO;

/**
 * Class Rule0001.
 *
 * @descSwagger=Exemplo de Rule
 * @classeSwagger=Rule0001
 *
 */
class Rule0001 implements RuleInterface
{
    private RulesTranslate $rulesTranslate;

    /**
     * Rule0001 constructor.
     */
    public function __construct(RulesTranslate $rulesTranslate)
    {
        $this->rulesTranslate = $rulesTranslate;
    }

    public function supports(): array
    {
        return [
            MensagemDTO::class => [
                'assetCreate',
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
        //$palavra = 'secreto';

        //if (strpos($restDto->getAssunto(), $palavra) !== false) {
        $this->rulesTranslate->throwException('mensagem', '0001');
        //}

        return true;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
