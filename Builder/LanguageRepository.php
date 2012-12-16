<?php

namespace Dark\DissectBundle\Builder;

/**
 * Storage languages
 *
 * @todo Add caching feature
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class LanguageRepository
{
    private $lb;
    private $languageHolder;
    private $pathHolder;

    public function __construct(LanguageBuilder $lb)
    {
        $this->lb = $lb;
        $this->languageHolder = array();
        $this->pathHolder = array();
    }

    /**
     * Adds path to languages YAML configs
     */
    public function addPath($name, $path)
    {
        $this->pathHolder[$name] = $path;
    }

    /**
     * Builds language if not built yet.
     */
    public function get($name)
    {
        if (isset($this->languageHolder[$name])) {
            return $this->languageHolder[$name];
        } else {
            if (isset($this->pathHolder[$name])) {
                return $this->languageHolder[$name] = $this->lb->build($this->pathHolder[$name]);
            } else {
                throw new \RuntimeException(sprintf('Language "%s" not found', $name));
            }
        }
    }
}
