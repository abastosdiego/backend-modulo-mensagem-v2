<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend\Api\V1\DTO;

use DateTime;
use DMS\Filter\Rules as Filter;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use SuppCore\AdministrativoBackend\DTO\RestDto;
use SuppCore\AdministrativoBackend\DTO\Traits\Blameable;
use SuppCore\AdministrativoBackend\DTO\Traits\IdUuid;
use SuppCore\AdministrativoBackend\DTO\Traits\Softdeleteable;
use SuppCore\AdministrativoBackend\DTO\Traits\Timeblameable;
use SuppCore\AdministrativoBackend\Form\Attributes as Form;
use SuppCore\AdministrativoBackend\Mapper\Attributes as DTOMapper;
use Symfony\Component\Validator\Constraints as Assert;

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
}
