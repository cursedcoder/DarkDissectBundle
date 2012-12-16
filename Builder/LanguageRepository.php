<?php

namespace Dark\DissectBundle\Builder;

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

    public function addPath($name, $path)
    {
        $this->pathHolder[$name] = $path;
    }
    
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
