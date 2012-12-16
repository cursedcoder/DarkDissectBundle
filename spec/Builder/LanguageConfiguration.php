<?php

namespace spec\Dark\DissectBundle\Builder;

use PHPSpec2\ObjectBehavior;

class LanguageConfiguration extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\Builder\LanguageConfiguration');
    }

    function its_getConfigTreeBuilder_shoud_return_TreeBuilder()
    {
        $this->getConfigTreeBuilder()->shouldBeAnInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
