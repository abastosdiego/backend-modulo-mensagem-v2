<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\DTO;

use DateTime;
use DMS\Filter\Rules as Filter;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use SuppCore\AdministrativoBackend\Api\V1\DTO\Setor as SetorDTO;
use SuppCore\AdministrativoBackend\Entity\Setor as SetorEntity;
use SuppCore\AdministrativoBackend\DTO\RestDto;
use SuppCore\AdministrativoBackend\DTO\Traits\Blameable;
use SuppCore\AdministrativoBackend\DTO\Traits\IdUuid;
use SuppCore\AdministrativoBackend\DTO\Traits\Softdeleteable;
use SuppCore\AdministrativoBackend\DTO\Traits\Timeblameable;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Form\Attributes as Form;
use SuppCore\AdministrativoBackend\Mapper\Attributes as DTOMapper;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use SuppMB\MensagemBackend\Api\V1\DTO\Tramite as TramiteDTO;

/**
 * Class Mensagem.
 */
#[DTOMapper\JsonLD(
    jsonLDId: '/v1/mensagem/{id}',
    jsonLDType: 'Mensagem',
    jsonLDContext: '/api/doc/#model-mensagem'
)]
#[Form\Form]
class Mensagem extends RestDto
{
    use IdUuid;
    use Timeblameable;
    use Blameable;
    use Softdeleteable;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\TextType',
        options: [
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'string')]
    #[DTOMapper\Property]
    protected ?string $dataHora = '';

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\TextType',
        options: [
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo Assunto não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo Assunto não pode ser nulo!')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'O campo Assunto deve ter no mínimo 3 caracteres!',
        maxMessage: 'O campo Assunto deve ter no máximo 100 caracteres!'
    )]
    #[OA\Property(type: 'string')]
    #[DTOMapper\Property]
    protected ?string $assunto = null;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\TextType',
        options: [
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo Texto não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo Texto não pode ser nulo!')]
    #[Assert\Length(
        min: 10,
        max: 2000,
        minMessage: 'O campo Texto deve ter no mínimo 10 caracteres!',
        maxMessage: 'O campo Texto deve ter no máximo 2000 caracteres!'
    )]
    #[OA\Property(type: 'string')]
    #[DTOMapper\Property]
    protected ?string $texto = null;
    
    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\TextType',
        options: [
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'string')]
    #[DTOMapper\Property]
    protected ?string $observacao = null;

    #[OA\Property(type: 'string', format: 'date-time')]
    #[DTOMapper\Property]
    protected ?DateTime $dataEntrada = null;
    
    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\TextType',
        options: [
            'required' => true,
        ]
    )]
    #[OA\Property(type: 'string')]
    #[DTOMapper\Property]
    protected ?string $sigilo = null;

    #[OA\Property(type: 'boolean')]
    #[DTOMapper\Property]
    protected ?bool $rascunho = null;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\DateTimeType',
        options: [
            'widget' => 'single_text',
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'string', format: 'date-time')]
    #[DTOMapper\Property]
    protected ?DateTime $prazoTransmissao = null;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\DateTimeType',
        options: [
            'widget' => 'single_text',
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'string', format: 'date-time')]
    #[DTOMapper\Property]
    protected ?DateTime $dataAutorizacao = null;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\CheckboxType',
        options: [
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'boolean')]
    #[DTOMapper\Property]
    protected ?bool $exigeResposta = null;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\DateTimeType',
        options: [
            'widget' => 'single_text',
            'required' => false,
        ]
    )]
    #[OA\Property(type: 'string', format: 'date-time')]
    #[DTOMapper\Property]
    protected ?DateTime $prazoResposta = null;

    #[Form\Field(
        'Symfony\Bridge\Doctrine\Form\Type\EntityType',
        options: [
            'class' => 'SuppCore\AdministrativoBackend\Entity\Setor',
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo não pode ser nulo!')]
    #[OA\Property(ref: new Model(type: SetorDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppCore\AdministrativoBackend\Api\V1\DTO\Setor')]
    protected ?EntityInterface $unidadeOrigem = null;

    #[Form\Field(
        'Symfony\Bridge\Doctrine\Form\Type\EntityType',
        options: [
            'class' => 'SuppMB\MensagemBackend\Entity\Tramite',
            'required' => false,
        ]
    )]
    #[OA\Property(ref: new Model(type: TramiteDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppMB\MensagemBackend\Api\V1\DTO\Tramite')]
    protected ?EntityInterface $tramite = null;

    public function getDataHora(): ?string
    {
        return $this->dataHora;
    }

    public function setDataHora(?string $dataHora): self
    {
        $this->setVisited('dataHora');

        $this->dataHora = $dataHora;

        return $this;
    }

    public function getAssunto(): ?string
    {
        return $this->assunto;
    }

    public function setAssunto(?string $assunto): self
    {
        $this->setVisited('assunto');

        $this->assunto = $assunto;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(?string $texto): self
    {
        $this->setVisited('texto');

        $this->texto = $texto;

        return $this;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): self
    {
        $this->setVisited('observacao');

        $this->observacao = $observacao;

        return $this;
    }

    public function getDataEntrada(): ?DateTime
    {
        return $this->dataEntrada;
    }

    public function setDataEntrada(?DateTime $dataEntrada): self
    {
        $this->setVisited('dataEntrada');

        $this->dataEntrada = $dataEntrada;

        return $this;
    }

    public function getSigilo(): ?string
    {
        return $this->sigilo;
    }

    public function setSigilo(?string $sigilo): self
    {
        $this->setVisited('sigilo');

        $this->sigilo = $sigilo;

        return $this;
    }

    public function getRascunho(): ?bool
    {
        return $this->rascunho;
    }

    public function setRascunho(?bool $rascunho): self
    {
        $this->setVisited('rascunho');

        $this->rascunho = $rascunho;

        return $this;
    }

    public function getPrazoTransmissao(): ?DateTime
    {
        return $this->prazoTransmissao;
    }

    public function setPrazoTransmissao(?DateTime $prazoTransmissao): self
    {
        $this->setVisited('prazoTransmissao');

        $this->prazoTransmissao = $prazoTransmissao;

        return $this;
    }

    public function getDataAutorizacao(): ?DateTime
    {
        return $this->dataAutorizacao;
    }

    public function setDataAutorizacao(?DateTime $dataAutorizacao): self
    {
        $this->setVisited('dataAutorizacao');

        $this->dataAutorizacao = $dataAutorizacao;

        return $this;
    }

    public function getExigeResposta(): ?bool
    {
        return $this->exigeResposta;
    }

    public function setExigeResposta(?bool $exigeResposta): self
    {
        $this->setVisited('exigeResposta');

        $this->exigeResposta = $exigeResposta;

        return $this;
    }

    public function getPrazoResposta(): ?DateTime
    {
        return $this->prazoResposta;
    }

    public function setPrazoResposta(?DateTime $prazoResposta): self
    {
        $this->setVisited('prazoResposta');

        $this->prazoResposta = $prazoResposta;

        return $this;
    }

    /**
     * @return SetorDTO|SetorEntity|null
     */
    public function getUnidadeOrigem(): ?EntityInterface
    {
        return $this->unidadeOrigem;
    }

    /**
     * @param SetorDTO|SetorEntity|null $unidadeOrigem
     *
     * @return self
     */
    public function setUnidadeOrigem(?EntityInterface $unidadeOrigem): self
    {
        $this->setVisited('unidadeOrigem');

        $this->unidadeOrigem = $unidadeOrigem;

        return $this;
    }

    public function getTramite(): ?EntityInterface
    {
        return $this->tramite;
    }

    public function setTramite(?EntityInterface $tramite): self
    {
        $this->setVisited('tramite');

        $this->tramite = $tramite;

        return $this;
    }
}
