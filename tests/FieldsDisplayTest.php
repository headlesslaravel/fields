<?php declare(strict_types=1);

use HeadlessLaravel\Fields\Fields;
use HeadlessLaravel\Fields\Text;
use PHPUnit\Framework\TestCase;

final class FieldsDisplayTest extends TestCase
{
    public function testDisplayFieldsBasicSetup()
    {
        $fields = Fields::display([
            Text::make('Name'),
            Text::make('Email Address', 'email'),
        ]);

        $this->assertEquals('name', $fields[0]['key']);
        $this->assertEquals('Name', $fields[0]['label']);
        $this->assertEquals('text', $fields[0]['component']);

        $this->assertEquals('email', $fields[1]['key']);
        $this->assertEquals('Email Address', $fields[1]['label']);
        $this->assertEquals('text', $fields[1]['component']);
    }

    public function testDisplayFieldsWithArrayValuesSet()
    {
        $fields = Fields::display([
            Text::make('Name'),
            Text::make('Company', 'company.name'),
        ], [
            'name' => 'John Doe',
            'company' => [
                'name' => 'Acme',
            ],
        ]);

        $this->assertEquals('John Doe', $fields[0]['value']);
        $this->assertEquals('Acme', $fields[1]['value']);
    }
}
