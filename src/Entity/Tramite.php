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
#[ORM\Table(name: 'mb_msg_tramite')]
class Tramite implements EntityInterface
{
    // Traits
    use Blameable;
    use Timestampable;
    use Softdeleteable;
    use Id;
    use Uuid;

    // #[ORM\OneToOne(targetEntity: 'Mensagem', inversedBy: 'tramite')]
    // #[ORM\JoinColumn(name: 'mensagem_id', referencedColumnName: 'id', nullable: false)]
    // protected ?Mensagem $mensagem = null;

    #[ORM\ManyToOne(targetEntity: 'SuppCore\AdministrativoBackend\Entity\Usuario')]
    #[ORM\JoinColumn(name: 'usuario_atual_id', referencedColumnName: 'id', nullable: true)]
    protected ?Usuario $usuario_atual = null;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setUuid();
    }

    // public function getMensagem(): ?Mensagem
    // {
    //     return $this->mensagem;
    // }

    // public function setMensagem(?Mensagem $mensagem): self
    // {
    //     $this->mensagem = $mensagem;

    //     return $this;
    // }

    public function getUsuarioAtual(): ?Usuario
    {
        return $this->usuario_atual;
    }

    public function setUsuarioAtual(?Usuario $usuario_atual): self
    {
        $this->usuario_atual = $usuario_atual;

        return $this;
    }
}
