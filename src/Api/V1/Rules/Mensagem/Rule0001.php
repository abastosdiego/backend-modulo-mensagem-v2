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
 * @descSwagger=Exemplo de Rule
 * @classeSwagger=Rule0001
 *
 */
class Rule0001 implements RuleInterface
{
    private $usuarioLogado;

    public function __construct(private RulesTranslate $rulesTranslate, private TokenStorageInterface $tokenStorage) 
    {
        $this->usuarioLogado = $this->tokenStorage->getToken()->getUser();
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
        //$this->usuarioLogado;

        $palavra = 'secreto';

        if (strpos($restDto->getAssunto(), $palavra) !== false) {
            $this->rulesTranslate->throwException('mensagem', '0001');
        }

        return true;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
