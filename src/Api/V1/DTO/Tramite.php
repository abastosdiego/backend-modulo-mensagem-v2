<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\DTO;

use DateTime;
use DMS\Filter\Rules as Filter;
use Doctrine\Common\Collections\Collection;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use SuppCore\AdministrativoBackend\Api\V1\DTO\Usuario as UsuarioDTO;
use SuppCore\AdministrativoBackend\DTO\RestDto;
use SuppCore\AdministrativoBackend\DTO\Traits\Blameable;
use SuppCore\AdministrativoBackend\DTO\Traits\IdUuid;
use SuppCore\AdministrativoBackend\DTO\Traits\Softdeleteable;
use SuppCore\AdministrativoBackend\DTO\Traits\Timeblameable;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Form\Attributes as Form;
use SuppCore\AdministrativoBackend\Mapper\Attributes as DTOMapper;
use Symfony\Component\Validator\Constraints as Assert;

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem as MensagemDTO;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

/**
 * Class Tramite.
 */
#[DTOMapper\JsonLD(
    jsonLDId: '/v1/tramite/{id}',
    jsonLDType: 'Tramite',
    jsonLDContext: '/api/doc/#model-tramite'
)]
#[Form\Form]
class Tramite extends RestDto
{
    use IdUuid;
    use Timeblameable;
    use Blameable;
    use Softdeleteable;

    #[Form\Field(
        'Symfony\Bridge\Doctrine\Form\Type\EntityType',
        options: [
            'class' => 'SuppMB\MensagemBackend\Entity\Mensagem',
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo não pode ser nulo!')]
    #[OA\Property(ref: new Model(type: MensagemDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppMB\MensagemBackend\Api\V1\DTO\Mensagem')]
    protected ?EntityInterface $mensagem = null;
    
    #[OA\Property(ref: new Model(type: UsuarioDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppCore\AdministrativoBackend\Api\V1\DTO\Usuario')]
    protected ?EntityInterface $usuarioAtual = null;
    
    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\CollectionType',
        options: [
            'entry_type' => IntegerType::class,
            'required' => false,
            'allow_add' => true
        ]
    )]
    protected array $idUsuariosTramitesFuturos = [];


    public function getMensagem(): ?EntityInterface
    {
        return $this->mensagem;
    }

    public function setMensagem(?EntityInterface $mensagem): self
    {
        $this->setVisited('mensagem');

        $this->mensagem = $mensagem;

        return $this;
    }

    public function getUsuarioAtual(): ?EntityInterface
    {
        return $this->usuarioAtual;
    }

    public function setUsuarioAtual(?EntityInterface $usuarioAtual): self
    {
        $this->setVisited('usuarioAtual');

        $this->usuarioAtual = $usuarioAtual;

        return $this;
    }
    
    public function getIdUsuariosTramitesFuturos(): array
    {
        return $this->idUsuariosTramitesFuturos;
    }

    public function setIdUsuariosTramitesFuturos(array $idUsuariosTramitesFuturos): self
    {
        $this->idUsuariosTramitesFuturos = $idUsuariosTramitesFuturos;

        return $this;
    }
}
