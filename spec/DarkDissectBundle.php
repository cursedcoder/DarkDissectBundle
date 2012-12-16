<?php

namespace spec\Dark\DissectBundle;

use PHPSpec2\ObjectBehavior;

class DarkDissectBundle extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\DarkDissectBundle');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function its_build_should_add_compiler_pass_to_container($container)
    {
        $container->addCompilerPass->shouldBeCalled();

        $this->build($container);
    }
}
