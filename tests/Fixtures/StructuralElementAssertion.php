<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;

trait StructuralElementAssertion
{
    private function assertPropertyStructuralElement(
        PropertyStructuralElement $element,
        string $type,
        string $name
    ): void {
        $this->assertInstanceOf(PropertyStructuralElement::class, $element);
        $this->assertEquals($type, $element->getType());
        $this->assertEquals($name, $element->getName());
    }
}
