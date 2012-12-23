<?php

namespace Dark\DissectBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BuildLanguagesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $builderDefinition = $container->getDefinition(
            'dissect.language_builder'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'dissect.context'
        );

        foreach ($taggedServices as $id => $attributes) {
            $builderDefinition->addMethodCall(
                'addContext',
                array(new Reference($id))
            );
        }

        $config = current($container->getExtensionConfig('dark_dissect'));
        $repositoryDefinition = $container->getDefinition('dissect.language_repository');

        foreach ($config as $languageName => $languageData) {
            $path = $container->getParameterBag()->resolveValue($languageData['path']);

            $repositoryDefinition->addMethodCall('addPath', array($languageName, $path));
        }
    }
}
