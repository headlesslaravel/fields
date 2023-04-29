# Fields

[![Latest Version on Packagist](https://img.shields.io/packagist/v/headlesslaravel/fields.svg?style=flat-square)](https://packagist.org/packages/headlesslaravel/fields)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/headlesslaravel/fields/run-tests?label=tests)](

A Laravel package that simplifies the process of formatting fields for display and forms in your Inertia.js projects. With this package, you can easily define Vue components, and populate data when needed. This package is particularly useful for developers working with Laravel, Inertia.js, and Vue.js.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
- [Available Fields](#available-fields)
- [Contributing](#contributing)
- [License](#license)

## Installation

To install the Laravel Inertia Field Formatter package, you can use Composer:

```bash
composer require headlesslaravel/fields
```

## Usage

After installing the package, you can use the `Fields` class to create form and display field configurations. These configurations can be used to define Vue components and populate data when necessary.

To create a form field configuration, you can use the `Fields::form()` method:

```php
$fields = Fields::form([
    // Your field configurations
]);
```

To create a display field configuration, you can use the `Fields::display()` method:

```php
$fields = Fields::display([
    // Your field configurations
], $data);
```

Both methods accept an array of field configurations. You can create field configurations using the `Text::make()` method. The first parameter is the label for the field, and the second parameter is an optional key that will be used to populate data for display fields.

You can also chain additional properties to the field configuration, like setting the `span` property for the grid system:

```php
Text::make('First Name')->prop('span', 6)
```

## Examples

Here is a more generic example of using the Laravel Inertia Field Formatter package:

```php
// Form field configuration
$formFields = Fields::form([
    Text::make('First Name')->prop('span', 6),
    Text::make('Last Name')->prop('span', 6),
    Text::make('Email')->prop('span', 6),
    Text::make('Phone')->prop('span', 6),
]);

// Display field configuration
$displayFields = Fields::display([
    Text::make('Name', 'name'),
    Text::make('Email', 'email'),
    Text::make('Phone', 'phone'),
], $user);

// Return the field configurations as an array
return [
    'form' => $formFields,
    'display' => $displayFields,
];
```

# Available Fields

| Field       | Description                                                                                              |
|-------------|----------------------------------------------------------------------------------------------------------|
| Checkbox    | A field representing a checkbox input, allowing for boolean values.                                       |
| Count       | A field representing a counter, displaying the number of items in a collection.                          |
| Divider     | A field used to add a visual divider or separator between other fields in a form or display.             |
| Field       | The base field class from which all other field classes inherit.                                         |
| Fields      | A class responsible for creating and managing form and display field configurations.                     |
| Items       | A field representing a list of items, useful for displaying collections or arrays of data.               |
| Link        | A field representing a hyperlink, allowing navigation to other pages or resources.                       |
| Money       | A field representing a monetary value, formatted according to the specified currency and locale.         |
| Number      | A field representing a numeric input, allowing for integer or decimal values.                            |
| Panel       | A container for organizing and grouping related fields within a form or display.                         |
| Picker      | A field representing a picker input, allowing users to select an option from a list (e.g. date picker).  |
| Repeat      | A field allowing the user to input a set of repeating values, useful for creating dynamic forms.         |
| Section     | A container for organizing and grouping related fields within a form or display, with a title.           |
| Select      | A field representing a dropdown select input, allowing users to choose one or multiple options.          |
| Text        | A field representing a text input, allowing for single-line text values.                                |
| Textarea    | A field representing a textarea input, allowing for multi-line text values.                              |
| Timestamp   | A field representing a timestamp, displaying a formatted date and time based on a specified format.      |

## Contributing

Contributions are welcome! If you find a bug or have a suggestion, please open an issue on the GitHub repository. If you'd like to contribute code, please submit a pull request.

## License

This package is released under the [MIT License](https://opensource.org/licenses/MIT).
