<?php
declare(strict_types=1);

namespace SuppMB\MensagemBackend\DependencyInjection\Compiler;

use Symfony\Component\Yaml\Yaml;
use function array_keys;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;


class ParameterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $rules = Yaml::parse(file_get_contents(__DIR__.'/../../Resources/config/rules.yml'));
        $container->setParameter('rules', array_merge_recursive($container->getParameter('rules'), $rules));
    }
}
