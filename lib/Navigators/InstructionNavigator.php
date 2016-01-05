<?php

namespace Magium\Navigators;

use Magium\AbstractTestCase;
use Magium\InvalidConfigurationException;
use Magium\Themes\ThemeConfigurationInterface;
use Magium\WebDriver\WebDriver;

class InstructionNavigator
{
    
    protected $webdriver;
    protected $themeConfiguration;
    protected $testCase;
    
    public function __construct(
        ThemeConfigurationInterface $theme,
        AbstractTestCase $testCase,
        WebDriver $webdriver)
    {
        $this->themeConfiguration = $theme;
        $this->testCase = $testCase;
        $this->webdriver = $webdriver;
    }

    
    public function navigateTo(array $instructions)
    {
        $this->testCase->assertGreaterThan(0, count($instructions), 'Instruction navigator requires at least one instruction');

        foreach ($instructions as $instruction) {
            $this->testCase->assertCount(2, $instruction, 'Navigation instructions need to be a 2 member array.  First item is the instruction type, the second is the XPath');
            list($instruction, $xpath) = $instruction;
            $element = $this->webdriver->byXpath($xpath);
            $this->testCase->assertNotNull($element);
            $this->testCase->assertTrue($element->isDisplayed());
            
            switch ($instruction) {
                case WebDriver::INSTRUCTION_MOUSE_CLICK: 
                    $element->click();
                    break;
                case WebDriver::INSTRUCTION_MOUSE_MOVETO:
                    $this->webdriver->getMouse()->mouseMove($element->getCoordinates());
                    break;
                default:
                    throw new InvalidConfigurationException('Unknown login instruction: ' .$instruction );
                    break;
            }
        }
        
    }
    
}