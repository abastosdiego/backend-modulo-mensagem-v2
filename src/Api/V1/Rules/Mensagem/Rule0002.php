<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\Rules\Mensagem;

use DateTime;
use DomainException;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Usuario;
use SuppCore\AdministrativoBackend\Rules\Exceptions\RuleException;
use SuppCore\AdministrativoBackend\Rules\RuleInterface;
use SuppCore\AdministrativoBackend\Rules\RulesTranslate;

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem as MensagemDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class Rule0002.
 *
 * @descSwagger=Verifica se o usuário logado está lotado no unidadeOrigem
 * @classeSwagger=Rule0002
 *
 */
class Rule0002 implements RuleInterface
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
        if ($this->usuarioLogado instanceof Usuario) {

            if(count($this->usuarioLogado->getColaborador()->getLotacoes()) == 0) {
                $this->rulesTranslate->throwException('mensagem', '0002');
            }

            $encontrou = false;
            foreach ($this->usuarioLogado->getColaborador()->getLotacoes() as $lotacao) {
                
                if ($restDto->getUnidadeOrigem() == $lotacao->getSetor()->getParent()) {
                    $encontrou = true;
                    break;
                }
            }

            if (!$encontrou) {
                $this->rulesTranslate->throwException('mensagem', '0003');
            }
        } else {
            throw new \DomainException('Erro ao obter o usuário logado!');
        }

        return true;
    }

    public function getOrder(): int
    {
        return 2;
    }
}
