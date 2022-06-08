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

class AutoloadModelNodeCasterTest extends TestCase
{
    use StructuralElementAssertion;

    private Parser $parser;

    private AssignAutoloadArrayNodeCaster $caster;

    public function setUp(): void
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $this->caster = (new NodeCasterFactory())->create(NodeVisitorType::assignAutoloadModel());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_autoload_models(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $autoload['model'] = array('Settings/Role', 'User');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'Role', 'Role');

        $this->assertArrayHasKey(1, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[1], 'User', 'User');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_autoload_models_with_an_alias_name(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $autoload['model'] = ['Settings/Role' => 'role', 'User' => 'user'];
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'Role', 'role');

        $this->assertArrayHasKey(1, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[1], 'User', 'user');
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
        $autoload['model'] = array();
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertSame([], $propertyStructuralElements);
    }
}
