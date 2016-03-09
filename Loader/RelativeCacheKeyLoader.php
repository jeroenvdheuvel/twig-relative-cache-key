<?php

namespace jvdh\TwigRelativeCacheKeyBundle\Loader;

use Twig_LoaderInterface;

class RelativeCacheKeyLoader implements Twig_LoaderInterface
{
    /**
     * @var Twig_LoaderInterface
     */
    private $loader;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param Twig_LoaderInterface $loader
     * @param string $kernelRootDir
     */
    public function __construct(Twig_LoaderInterface $loader, $kernelRootDir)
    {
        $this->loader = $loader;
        $this->rootDir = dirname($kernelRootDir);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        $key = $this->loader->getCacheKey($name);

        if (strpos($key, $this->rootDir) === 0) {
            return substr($key, strlen($this->rootDir));
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        return $this->loader->getSource($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return $this->loader->isFresh($name, $time);
    }
}
