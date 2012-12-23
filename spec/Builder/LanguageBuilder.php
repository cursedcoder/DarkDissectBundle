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

    function its_build_should_throw_exception_for_not_yaml_sources()
    {
        $this->shouldThrow('Symfony\Component\Yaml\Exception\ParseException')->duringBuild(__DIR__.'/fixtures/broken_syntax.yml');
    }

    function its_build_should_not_work_with_yaml_source_and_not_existing_context()
    {
        $this->shouldThrow('RuntimeException')->duringBuild(__DIR__.'/fixtures/good_syntax.yml');
    }

    /**
     * @param \Dark\DissectBundle\Context\ContextInterface $context
     */
    function its_build_should_work_with_yaml_source_and_existing_context($context)
    {
        $context->getName()->willReturn('Context');
        $context->additive(ANY_ARGUMENTS)->willThrow('RuntimeException');

        $this->addContext($context);
        $language = $this->build(__DIR__.'/fixtures/good_syntax.yml');

        $language->shouldThrow('RuntimeException')->duringRead('2 + 2');
    }
}
