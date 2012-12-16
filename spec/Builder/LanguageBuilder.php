<?php

namespace spec\Dark\DissectBundle\Builder;

use PHPSpec2\ObjectBehavior;

class LanguageBuilder extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\Builder\LanguageBuilder');
    }

    function its_build_should_throw_exception_for_not_existing_language_file()
    {
        $this->shouldThrow('InvalidArgumentException')->duringBuild('/var/www/www/var/www/1.txt');
    }

    function its_build_should_throw_exception_for_not_yaml_files()
    {
        $this->shouldThrow('Symfony\Component\Yaml\Exception\ParseException')->duringBuild(__DIR__.'/broken_syntax.yml');
    }

    function its_build_should_not_work_with_yaml_file_and_not_existing_context($context)
    {
        $this->shouldThrow('RuntimeException')->duringBuild(__DIR__.'/good_syntax.yml');
    }

    /**
     * @param \Dark\DissectBundle\Context\ContextInterface $context
     */
    function its_build_should_work_with_yaml_file_and_existing_context($context)
    {
        $context->getName()->willReturn('Context');

        $this->addContext($context);
        $this->build(__DIR__.'/good_syntax.yml');
    }
}
