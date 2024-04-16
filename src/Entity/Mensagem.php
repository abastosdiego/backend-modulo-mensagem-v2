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

    #[ORM\Column(name: 'data_hora', type: 'string', nullable: true)]
    protected ?string $dataHora = '';

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
        max: 2000,
        minMessage: 'O campo Texto deve ter no mínimo 3 caracteres!',
        maxMessage: 'O campo Texto deve ter no máximo 2000 caracteres!'
    )]
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $texto = '';

    #[Assert\Length(
        max: 500,
        maxMessage: 'O campo Observação deve ter no máximo 500 caracteres!'
    )]
    #[ORM\Column(type: 'string', nullable: true)]
    protected string $observacao = '';

    #[ORM\Column(name: 'data_entrada', type: 'datetime', nullable: false)]
    protected DateTime $dataEntrada;

    #[ORM\Column(type: 'string', length: 20)]
    protected ?string $sigilo = 'ostensivo';

    #[ORM\Column]
    protected ?bool $rascunho = null;

    #[ORM\Column(name: 'prazo_transmissao', type: Types::DATE_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $prazoTransmissao = null;

    #[ORM\Column(name: 'data_autorizacao', type: Types::DATE_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $dataAutorizacao = null;

    #[ORM\Column(name: 'exige_resposta')]
    protected ?bool $exigeResposta = false;

    #[ORM\Column(name: 'prazo_resposta', type: Types::DATE_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $prazoResposta = null;

    #[Assert\NotNull(message: 'O campo unidadeOrigem não pode ser nulo!')]
    #[ORM\ManyToOne(targetEntity: 'SuppCore\AdministrativoBackend\Entity\Setor')]
    #[ORM\JoinColumn(name: 'unidade_origem_id', referencedColumnName: 'id', nullable: false)]
    protected Setor $unidadeOrigem;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setUuid();
        $this->dataEntrada = new \DateTime('now');
        $this->rascunho = true;
    }


    public function getDataHora(): ?string
    {
        return $this->dataHora;
    }

    public function setDataHora(?string $dataHora): self
    {
        $this->dataHora = $dataHora;

        return $this;
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

    public function getObservacao(): string
    {
        return $this->observacao;
    }

    public function setObservacao(string $observacao): self
    {
        $this->observacao = $observacao;

        return $this;
    }

    public function getDataEntrada(): DateTime
    {
        return $this->dataEntrada;
    }

    public function setDataEntrada(DateTime $dataEntrada): self
    {
        $this->dataEntrada = $dataEntrada;

        return $this;
    }

    public function getSigilo(): ?string
    {
        return $this->sigilo;
    }

    public function setSigilo(?string $sigilo): self
    {
        $this->sigilo = $sigilo;

        return $this;
    }

    public function getRascunho(): ?bool
    {
        return $this->rascunho;
    }

    public function setRascunho(?bool $rascunho): self
    {
        $this->rascunho = $rascunho;

        return $this;
    }

    public function getPrazoTransmissao(): ?\DateTimeInterface
    {
        return $this->prazoTransmissao;
    }

    public function setPrazoTransmissao(?\DateTimeInterface $prazoTransmissao): self
    {
        $this->prazoTransmissao = $prazoTransmissao;

        return $this;
    }

    public function getDataAutorizacao(): ?\DateTimeInterface
    {
        return $this->dataAutorizacao;
    }

    public function setDataAutorizacao(?\DateTimeInterface $dataAutorizacao): self
    {
        $this->dataAutorizacao = $dataAutorizacao;

        return $this;
    }

    public function getExigeResposta(): ?bool
    {
        return $this->exigeResposta;
    }

    public function setExigeResposta(bool $exigeResposta): self
    {
        $this->exigeResposta = $exigeResposta;

        return $this;
    }

    public function getPrazoResposta(): ?\DateTimeInterface
    {
        return $this->prazoResposta;
    }
    
    public function setPrazoResposta(?\DateTimeInterface $prazoResposta): self
    {
        $this->prazoResposta = $prazoResposta;

        return $this;
    }

    public function getUnidadeOrigem(): Setor
    {
        return $this->unidadeOrigem;
    }

    public function setUnidadeOrigem(Setor $unidadeOrigem): self
    {
        $this->unidadeOrigem = $unidadeOrigem;

        return $this;
    }
}
