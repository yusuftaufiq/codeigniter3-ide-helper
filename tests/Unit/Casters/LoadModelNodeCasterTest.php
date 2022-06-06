<?php

namespace Tests\Unit\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Casters\MethodCallNodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeCasterFactory;
use PhpParser\Node;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\StructuralElementAssertion;

class LoadModelNodeCasterTest extends TestCase
{
    use StructuralElementAssertion;

    private Parser $parser;

    private MethodCallNodeCaster $caster;

    public function setUp(): void
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $this->caster = (new NodeCasterFactory())->create(NodeVisitorType::methodCallLoadModel());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_model_node(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model('User');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'User', 'User');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_model_node_in_a_subdirectory(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model('Settings/Role');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'Role', 'Role');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_model_nodes_with_an_alias_name(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model('User', 'user');
        $this->load->model('Settings/Role', 'role');
        PHP);

        $userModelPropertyStructuralElements = $this->caster->cast($nodes[0]->expr);
        $roleModelPropertyStructuralElements = $this->caster->cast($nodes[1]->expr);

        $this->assertArrayHasKey(0, $userModelPropertyStructuralElements);
        $this->assertPropertyStructuralElement($userModelPropertyStructuralElements[0], 'User', 'user');
        $this->assertArrayHasKey(0, $roleModelPropertyStructuralElements);
        $this->assertPropertyStructuralElement($roleModelPropertyStructuralElements[0], 'Role', 'role');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_model_nodes_with_named_arguments(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model('Settings/Role', name: 'role');
        $this->load->model(model: 'Settings/Role', name: 'role');
        $this->load->model(name: 'role', model: 'Settings/Role');
        PHP);

        array_walk($nodes, function (Node\Stmt\Expression $node): void {
            $propertyStructuralElements = $this->caster->cast($node->expr);

            $this->assertArrayHasKey(0, $propertyStructuralElements);
            $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'Role', 'role');
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_return_an_empty_array_if_arguments_are_not_a_string(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model(new stdClass());
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertSame([], $propertyStructuralElements);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_return_an_empty_array_if_arguments_is_empty(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->model();
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertSame([], $propertyStructuralElements);
    }
}
