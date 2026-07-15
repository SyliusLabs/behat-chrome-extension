<?php

namespace tests\Behat\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use DMore\ChromeExtension\Behat\ServiceContainer\ChromeExtension;
use DMore\ChromeExtension\Behat\ServiceContainer\Driver\ChromeFactory;
use PHPUnit\Framework\TestCase;

class ChromeExtensionTest extends TestCase
{
    /** @var ChromeExtension */
    private $extension;

    public function setUp(): void
    {
        $this->extension = new ChromeExtension();
    }

    public function testConfigKey()
    {
        $this->assertSame('chrome', $this->extension->getConfigKey());
    }

    public function testItRegistersMinkDriver()
    {
        // Mock the Extension interface rather than the concrete MinkExtension: in
        // friends-of-behat/mink-extension v3 (Behat 4) that class is declared final and
        // cannot be doubled. registerDriverFactory() lives on MinkExtension only, so it is
        // added to the interface double explicitly.
        $mink_extension = $this->getMockBuilder(Extension::class)
            ->onlyMethods(['getConfigKey', 'initialize', 'configure', 'load', 'process'])
            ->addMethods(['registerDriverFactory'])
            ->getMock();
        $mink_extension->method('getConfigKey')->willReturn('mink');
        $extension_manager = new ExtensionManager([$mink_extension]);

        $mink_extension->expects($this->once())->method('registerDriverFactory')
            ->with($this->callback(function ($factory) {
                return $factory instanceof ChromeFactory;
            }));
        $this->extension->initialize($extension_manager);
    }
}
