<?php

namespace spec\Dark\DissectBundle\Builder;

use PHPSpec2\ObjectBehavior;

class LanguageRepository extends ObjectBehavior
{
    /**
     * @param \Dark\DissectBundle\Builder\LanguageBuilder $lb
     */
    function let($lb)
    {
        $this->beConstructedWith($lb);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Dark\DissectBundle\Builder\LanguageRepository');
    }

    /**
     * @param \Dark\DissectBundle\Builder\LanguageBuilder $lb
     */
    function its_addPath_should_add_new_item_to_pathHolder($lb)
    {
        $lb->build->willReturn('okay!');
        $this->beConstructedWith($lb);

        $this->addPath('extra_lang', 'some_path/lang.yml');
        $this->get('extra_lang')->shouldReturn('okay!');
    }

    function its_get_accessor_should_throw_exception_if_language_not_found()
    {
        $this->shouldThrow('Exception')->duringGet('not_existing_language_version_2225');
    }

    /**
     * @param \Dark\DissectBundle\Builder\LanguageBuilder $lb
     */
    function its_get_accessor_should_build_language_only_first_time($lb)
    {
        $lb->build->shouldBeCalled();
        $this->beConstructedWith($lb);

        $this->addPath('extra_lang', 'some_path/lang.yml');
        $this->get('extra_lang');

        $lb->build->shouldNotBeCalled();
        $this->get('extra_lang');
    }
}
