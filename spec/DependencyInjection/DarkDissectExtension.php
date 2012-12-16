<?php

namespace spec\Dark\DissectBundle\DependencyInjection;

use PHPSpec2\ObjectBehavior;

class DarkDissectExtension extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\DependencyInjection\DarkDissectExtension');
    }

    function its_getAlias_should_return_permanent_value()
    {
        $this->getAlias()->shouldReturn('dark_dissect');
        $this->getAlias()->shouldReturn('dark_dissect');
    }
}
