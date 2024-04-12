<?php

declare(strict_types=1);

namespace SuppMB\MensagemBackend;

use SuppMB\MensagemBackend\DependencyInjection\Compiler\ParameterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MensagemBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ParameterPass());
    }
}