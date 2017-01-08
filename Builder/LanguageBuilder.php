<?php

namespace Dark\DissectBundle\Builder;

use Dissect\Lexer\SimpleLexer;
use Dissect\Parser\Grammar;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

use Dark\DissectBundle\Context\ContextInterface;

/**
 * Builds new Language using custom Contexts and YAML config
 *
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class LanguageBuilder
{
    private $contextHolder;

    public function __construct()
    {
        $this->contextHolder = array();
    }

    public function addContext(ContextInterface $context)
    {
        $this->contextHolder[$context->getName()] = $context;
    }

    public function build($path)
    {
        $fileLocator = new FileLocator();
        $languageSource = Yaml::parse(file_get_contents($fileLocator->locate($path)));

        $processor = new Processor();
        $configuration = new LanguageConfiguration();

        $config = $processor->processConfiguration($configuration, $languageSource);

        return new Language(
            $this->prepareLexis($config['lexis']),
            $this->prepareGrammar($config['grammar'])
        );
    }

    private function prepareLexis($lexisSource)
    {
        $lexer = new SimpleLexer();

        if (isset($lexisSource['regex'])) {
            foreach ($lexisSource['regex'] as $name => $regex) {
                $lexer->regex($name, $regex);
            }
        }

        if (isset($lexisSource['tokens'])) {
            foreach ($lexisSource['tokens'] as $simpleToken) {
                $lexer->token($simpleToken);
            }
        }

        if (isset($lexisSource['skip'])) {
            $lexer->skip('wsp');
        }

        return $lexer;
    }

    private function prepareGrammar($grammarSource)
    {
        $grammar = new Grammar();
        $defaultContext = $this->getContext($grammarSource['default_context']);

        foreach ($grammarSource['rules'] as $ruleSource) {
            foreach ($ruleSource as $ruleName => $ruleData) {
                $rule = $grammar($ruleName);
                call_user_func_array([$rule, 'is'], $ruleData['statement']);

                if (isset($ruleData['call'])) {
                    $context = isset($ruleData['call']['context']) ? $this->getContext($ruleData['call']['context']) : $defaultContext;
                    $method = isset($ruleData['call']['method']) ? $ruleData['call']['method'] : $ruleName;

                    $rule->call(array($context, $method));
                }
            }
        }

        if (isset($grammarSource['start_rule'])) {
            $grammar->start($grammarSource['start_rule']);
        }

        return $grammar;
    }

    private function getContext($name)
    {
        if (!isset($this->contextHolder[$name])) {
            throw new \RuntimeException(sprintf('Context %s is not exist or was not loaded', $name));
        }

        return $this->contextHolder[$name];
    }
}
