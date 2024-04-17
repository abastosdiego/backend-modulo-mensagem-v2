<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Entity;

use DateTime;
use DMS\Filter\Rules as Filter;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use SuppCore\AdministrativoBackend\Entity\Setor;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Traits\Blameable;
use SuppCore\AdministrativoBackend\Entity\Traits\Id;
use SuppCore\AdministrativoBackend\Entity\Traits\Softdeleteable;
use SuppCore\AdministrativoBackend\Entity\Traits\Timestampable;
use SuppCore\AdministrativoBackend\Entity\Traits\Uuid;
use SuppCore\AdministrativoBackend\Entity\Usuario;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[Gedmo\SoftDeleteable(fieldName: 'apagadoEm')]
#[Gedmo\Loggable]
#[ORM\Table(name: 'mb_msg_tramite_futuro')]
class TramiteFuturo implements EntityInterface
{
    // Traits
    use Blameable;
    use Timestampable;
    use Softdeleteable;
    use Id;
    use Uuid;

    #[Assert\NotNull(message: 'O campo Ordem não pode ser nulo!')]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ordem = 0;

    #[Assert\NotNull(message: 'O campo Tramite não pode ser nulo!')]
    #[ORM\ManyToOne(inversedBy: 'tramites_futuros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tramite $tramite = null;

    #[Assert\NotNull(message: 'O campo Usuario não pode ser nulo!')]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setUuid();
    }

    public function getOrdem(): ?int
    {
        return $this->ordem;
    }

    public function setOrdem(?int $ordem): self
    {
        $this->ordem = $ordem;

        return $this;
    }

    public function getTramite(): ?Tramite
    {
        return $this->tramite;
    }

    public function setTramite(?Tramite $tramite): self
    {
        $this->tramite = $tramite;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

}
