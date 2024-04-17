<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\DTO;

use DateTime;
use DMS\Filter\Rules as Filter;
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

use SuppMB\MensagemBackend\Api\V1\DTO\Tramite as TramiteDTO;

/**
 * Class TramiteFuturo.
 */
#[DTOMapper\JsonLD(
    jsonLDId: '/v1/tramite-futuro/{id}',
    jsonLDType: 'TramiteFuturo',
    jsonLDContext: '/api/doc/#model-tramitefuturo'
)]
#[Form\Form]
class TramiteFuturo extends RestDto
{
    use IdUuid;
    use Timeblameable;
    use Blameable;
    use Softdeleteable;

    #[Form\Field(
        'Symfony\Component\Form\Extension\Core\Type\IntegerType',
        options: [
            'required' => true,
        ]
    )]
    #[OA\Property(type: 'integer')]
    #[DTOMapper\Property]
    protected ?int $ordem = null;

    #[Form\Field(
        'Symfony\Bridge\Doctrine\Form\Type\EntityType',
        options: [
            'class' => 'SuppMB\MensagemBackend\Entity\Tramite',
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo não pode ser nulo!')]
    #[OA\Property(ref: new Model(type: TramiteDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppMB\MensagemBackend\Api\V1\DTO\Tramite')]
    protected ?EntityInterface $tramite = null;
    
    #[Form\Field(
        'Symfony\Bridge\Doctrine\Form\Type\EntityType',
        options: [
            'class' => 'SuppCore\AdministrativoBackend\Entity\Usuario',
            'required' => true,
        ]
    )]
    #[Assert\NotBlank(message: 'O campo não pode estar em branco!')]
    #[Assert\NotNull(message: 'O campo não pode ser nulo!')]
    #[OA\Property(ref: new Model(type: UsuarioDTO::class))]
    #[DTOMapper\Property(dtoClass: 'SuppCore\AdministrativoBackend\Api\V1\DTO\Usuario')]
    protected ?EntityInterface $usuario = null;
    

    public function getOrdem(): ?int
    {
        return $this->ordem;
    }

    public function setOrdem(?int $ordem): self
    {
        $this->setVisited('ordem');

        $this->ordem = $ordem;

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

    public function getUsuario(): ?EntityInterface
    {
        return $this->usuario;
    }

    public function setUsuario(?EntityInterface $usuario): self
    {
        $this->setVisited('usuario');

        $this->usuario = $usuario;

        return $this;
    }
}
