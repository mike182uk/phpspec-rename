#### ⚠️ This project is no longer maintained

# PHPSpec Rename

[![Build Status](https://img.shields.io/travis/mike182uk/phpspec-rename.svg?style=flat-square)](http://travis-ci.org/mike182uk/phpspec-rename)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/mike182uk/phpspec-rename.svg?style=flat-square)](https://scrutinizer-ci.com/g/mike182uk/phpspec-rename/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9f4373d9-6408-473e-8154-86d03b491582/mini.png)](https://insight.sensiolabs.com/projects/9f4373d9-6408-473e-8154-86d03b491582)
[![Total Downloads](https://img.shields.io/packagist/dt/mike182uk/phpspec-rename.svg?style=flat-square)](https://packagist.org/packages/mike182uk/phpspec-rename)
[![License](https://img.shields.io/github/license/mike182uk/phpspec-rename.svg?style=flat-square)](https://packagist.org/packages/mike182uk/phpspec-rename)

Use PHPSpec to rename a class and its corresponding spec.

## Installation

Add this package as a dependency in your `composer.json`.

```json
{
    "require-dev": {
        "mike182uk/phpspec-rename": "0.1.*"
    }
}
```

Enable the extension in your `phpspec.yml`.

```
extensions:
  - Mdb\PhpSpecRenameExtension\Extension
```

## Usage

```bash
bin/phpspec rename Foo/Bar Foo/Bar/Baz
```
