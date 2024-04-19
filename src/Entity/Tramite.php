<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Entity;

use DateTime;
use DMS\Filter\Rules as Filter;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(targetEntity: Mensagem::class, inversedBy: 'tramite')]
    #[ORM\JoinColumn(name: 'mensagem_id', referencedColumnName: 'id', nullable: false)]
    protected ?Mensagem $mensagem = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_atual_id', referencedColumnName: 'id', nullable: false)]
    protected ?Usuario $usuarioAtual = null;

    #[ORM\OneToMany(targetEntity: TramitePassado::class, mappedBy: 'tramite', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $tramitesPassados;

    #[ORM\OneToMany(targetEntity: TramiteFuturo::class, mappedBy: 'tramite', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $tramitesFuturos;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setUuid();
    }

    public function getMensagem(): ?Mensagem
    {
        return $this->mensagem;
    }

    public function setMensagem(?Mensagem $mensagem): self
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    public function getUsuarioAtual(): ?Usuario
    {
        return $this->usuarioAtual;
    }

    public function setUsuarioAtual(?Usuario $usuarioAtual): self
    {
        $this->usuarioAtual = $usuarioAtual;

        return $this;
    }

    public function getTramitesPassados(): Collection
    {
        return $this->tramitesPassados;
    }

    // public function setTramitesPassados(Collection $tramitesPassados): self
    // {
    //     $this->tramitesPassados = $tramitesPassados;

    //     return $this;
    // }

    public function getTramitesFuturos(): Collection
    {
        return $this->tramitesFuturos;
    }

    public function setTramitesFuturos(Collection $tramitesFuturos): self
    {
        $this->tramitesFuturos = $tramitesFuturos;

        return $this;
    }

    public function removeTramiteFuturo(TramiteFuturo $tramiteFuturo): self
    {
        $this->tramitesFuturos->removeElement($tramiteFuturo);

        return $this;
    }

    public function limparTramitesFuturos() {
        $this->tramitesFuturos = [];
    }

    public function getProximoTramiteFuturo(): TramiteFuturo
    {
        if (count($this->getTramitesFuturos()) == 0) { new \DomainException("Trâmite não definido!");}

        return (object) $this->tramitesFuturos[0];
    }
}
