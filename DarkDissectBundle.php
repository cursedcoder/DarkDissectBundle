<?php

namespace Dark\DissectBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Dark\DissectBundle\DependencyInjection\Compiler\BuildLanguagesPass;

/**
 * Hey :)
 *
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class DarkDissectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BuildLanguagesPass());
    }
}
