<?php

namespace spec\Dark\DissectBundle\DependencyInjection;

use PHPSpec2\ObjectBehavior;

class Configuration extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\DependencyInjection\Configuration');
    }

    function its_getConfigTreeBuilder_shoud_return_TreeBuilder()
    {
        $this->getConfigTreeBuilder()->shouldBeAnInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
