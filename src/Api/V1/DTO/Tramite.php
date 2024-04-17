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

use SuppMB\MensagemBackend\Api\V1\DTO\Mensagem as MensagemDTO;

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
    protected ?EntityInterface $usuario_atual = null;
    
    
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
        return $this->usuario_atual;
    }

    public function setUsuarioAtual(?EntityInterface $usuario_atual): self
    {
        $this->setVisited('usuario_atual');

        $this->usuario_atual = $usuario_atual;

        return $this;
    }
}
