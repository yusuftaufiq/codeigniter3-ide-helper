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

class LoadLibraryNodeCasterTest extends TestCase
{
    use StructuralElementAssertion;

    private Parser $parser;

    private MethodCallNodeCaster $caster;

    public function setUp(): void
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $this->caster = (new NodeCasterFactory())->create(NodeVisitorType::methodCallLoadLibrary());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_default_library_node(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library('form_validation');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'CI_Form_validation', 'form_validation');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_custom_library_node(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library('Authorization/Gate');
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'Gate', 'Gate');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_library_nodes_with_an_alias_name(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library('form_validation', null, 'formValidation');
        $this->load->library('Authorization/Gate', [], 'gate');
        PHP);

        $formValidationLibraryPropertyStructuralElements = $this->caster->cast($nodes[0]->expr);
        $gateLibraryPropertyStructuralElements = $this->caster->cast($nodes[1]->expr);

        $this->assertArrayHasKey(0, $formValidationLibraryPropertyStructuralElements);
        $this->assertPropertyStructuralElement($formValidationLibraryPropertyStructuralElements[0], 'CI_Form_validation', 'formValidation');
        $this->assertArrayHasKey(0, $gateLibraryPropertyStructuralElements);
        $this->assertPropertyStructuralElement($gateLibraryPropertyStructuralElements[0], 'Gate', 'gate');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_library_node_with_array_arguments(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library(array('image_lib' => 'imageLib', 'form_validation' => 'formValidation'));
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertArrayHasKey(0, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'CI_Image_lib', 'imageLib');
        $this->assertArrayHasKey(1, $propertyStructuralElements);
        $this->assertPropertyStructuralElement($propertyStructuralElements[1], 'CI_Form_validation', 'formValidation');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_be_able_to_cast_load_library_nodes_with_named_arguments(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library('session', object_name: 'appSession');
        $this->load->library(library: 'session', object_name: 'appSession');
        $this->load->library(object_name: 'appSession', library: 'session');
        $this->load->library(library: ['session' => 'appSession']);
        PHP);

        array_walk($nodes, function (Node\Stmt\Expression $node): void {
            $propertyStructuralElements = $this->caster->cast($node->expr);

            $this->assertArrayHasKey(0, $propertyStructuralElements);
            $this->assertPropertyStructuralElement($propertyStructuralElements[0], 'CI_Session', 'appSession');
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_return_an_empty_array_if_arguments_are_not_a_string_or_array(): void
    {
        $nodes = $this->parser->parse(<<<'PHP'
        <?php
        $this->load->library(new stdClass());
        $this->load->library([new stdClass()]);
        $this->load->library(object_name: []);
        PHP);

        array_walk($nodes, function (Node\Stmt\Expression $node): void {
            $propertyStructuralElements = $this->caster->cast($node->expr);

            $this->assertSame([], $propertyStructuralElements);
        });
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
        $this->load->library();
        PHP);

        $propertyStructuralElements = $this->caster->cast($nodes[0]->expr);

        $this->assertSame([], $propertyStructuralElements);
    }
}
