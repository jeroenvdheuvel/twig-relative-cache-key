<?php

namespace jvdh\TwigRelativeCacheKeyBundle\Tests\Loader;

use jvdh\TwigRelativeCacheKeyBundle\Loader\RelativeCacheKeyLoader;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Twig_LoaderInterface;

class RelativeCacheKeyLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testGetSource()
    {
        $name = 'template-name';
        $source = 'source';

        $mockedLoader = $this->getMockedLoader();
        $mockedLoader->expects($this->once())
            ->method('getSource')
            ->with($name)
            ->willReturn($source);

        $relativeCacheKeyLoader = new RelativeCacheKeyLoader($mockedLoader, '');
        $this->assertSame($source, $relativeCacheKeyLoader->getSource($name));
    }

    public function testIsFresh()
    {
        $name = 'template-name';
        $timeOfLastModification = 123;
        $isFresh = false;

        $mockedLoader = $this->getMockedLoader();
        $mockedLoader->expects($this->once())
            ->method('isFresh')
            ->with($name, $timeOfLastModification)
            ->willReturn($isFresh);

        $relativeCacheKeyLoader = new RelativeCacheKeyLoader($mockedLoader, '');
        $this->assertSame($isFresh, $relativeCacheKeyLoader->isFresh($name, $timeOfLastModification));
    }

    public function testGetCacheKey_withKernelRootDirThatDoesNotMatch_returnsUnchangedKey()
    {
        $kernelRootDir = __FILE__;
        $name = 'template-name';
        $cacheKey = 'cache-key';

        $mockedLoader = $this->getMockedLoader();
        $mockedLoader->expects($this->once())
            ->method('getCacheKey')
            ->with($name)
            ->willReturn($cacheKey);

        $relativeCacheKeyLoader = new RelativeCacheKeyLoader($mockedLoader, $kernelRootDir);
        $this->assertSame($cacheKey, $relativeCacheKeyLoader->getCacheKey($name));
    }

    public function testGetCacheKey_withKernelRootDirThatDoesMatches_returnsChangedKey()
    {
        $kernelRootDir = __FILE__;
        $name = 'template name';
        $cacheKeyPostfix = 'cache-key';
        $cacheKey = $kernelRootDir . $cacheKeyPostfix;
        $expectedKey = DIRECTORY_SEPARATOR . basename($kernelRootDir) . $cacheKeyPostfix;

        $mockedLoader = $this->getMockedLoader();
        $mockedLoader->expects($this->once())
            ->method('getCacheKey')
            ->with($name)
            ->willReturn($cacheKey);

        $relativeCacheKeyLoader = new RelativeCacheKeyLoader($mockedLoader, $kernelRootDir);
        $this->assertSame($expectedKey, $relativeCacheKeyLoader->getCacheKey($name));
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|Twig_LoaderInterface
     */
    private function getMockedLoader()
    {
        return $this->getMockBuilder(Twig_LoaderInterface::class)->disableOriginalConstructor()->getMock();
    }
}
