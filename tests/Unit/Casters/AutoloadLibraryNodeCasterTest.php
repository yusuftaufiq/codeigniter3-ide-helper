<?php

declare(strict_types=1);

namespace Test\Unit\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Casters\AssignAutoloadArrayNodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeCasterFactory;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\StructuralElementAssertion;

class AutoloadLibraryNodeCasterTest extends TestCase
{
    use StructuralElementAssertion;

    private Parser $parser;

    private AssignAutoloadArrayNodeCaster $caster;

    public function setUp(): void
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $this->caster = (new NodeCasterFactory())->create(NodeVisitorType::assignAutoloadLibrary());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_autoload_default_libraries(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $autoload['libraries'] = array('session', 'email');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'CI_Session', 'session');

        $this->assertArrayHasKey(1, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[1], 'CI_Email', 'email');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_autoload_default_libraries_with_an_alias_name(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $autoload['libraries'] = ['session' => 'mySession', 'form_validation' => 'myFormValidation'];
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'CI_Session', 'mySession');

        $this->assertArrayHasKey(1, $propertyStructuralElements);
        $this->assertPropertyStructuralElement(
            $propertyStructuralElements[1],
            'CI_Form_validation',
            'myFormValidation',
        );
    }

    /**
     * @test
     *
     * @requires void
     */
    public function it_should_return_an_empty_array_if_arguments_is_empty(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $autoload['libraries'] = array();
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertSame([], $propertyStructuralElements);
    }
}
