<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Entity;

use DateTime;
use DMS\Filter\Rules as Filter;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Traits\Blameable;
use SuppCore\AdministrativoBackend\Entity\Traits\Id;
use SuppCore\AdministrativoBackend\Entity\Traits\Softdeleteable;
use SuppCore\AdministrativoBackend\Entity\Traits\Timestampable;
use SuppCore\AdministrativoBackend\Entity\Traits\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[Gedmo\SoftDeleteable(fieldName: 'apagadoEm')]
#[Gedmo\Loggable]
#[ORM\Table(name: 'mb_msg_mensagem')]
class Mensagem implements EntityInterface
{
    // Traits
    use Blameable;
    use Timestampable;
    use Softdeleteable;
    use Id;
    use Uuid;

    #[Assert\NotBlank(message: 'O campo Assunto não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo Assunto não pode ser nulo!')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'O campo Assunto deve ter no mínimo 3 caracteres!',
        maxMessage: 'O campo Assunto deve ter no máximo 100 caracteres!'
    )]
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $assunto = '';

    #[Assert\NotBlank(message: 'O campo Texto não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo Texto não pode ser nulo!')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'O campo Texto deve ter no mínimo 3 caracteres!',
        maxMessage: 'O campo Texto deve ter no máximo 100 caracteres!'
    )]
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $texto = '';


    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setUuid();
    }

    public function getAssunto(): string
    {
        return $this->assunto;
    }

    public function setAssunto(string $assunto): self
    {
        $this->assunto = $assunto;

        return $this;
    }

    public function getTexto(): string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }
}
