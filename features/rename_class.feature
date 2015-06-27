Feature: Rename class
  In order to improve my efficiency when renaming a class
  As a developer
  I want to be able to rename a class and its corresponding spec with PHPSpec

  Scenario Outline: Class is renamed
    Given "<src>" exists
    When I rename "<src>" to "<target>"
    Then "<target>" should exist
    And "<src>" should not exist

    Examples:
      | src             | target              |
      | Foo\Bar         | Foo\Baz             |
      | Foo\Bar\Baz     | Foo\Baz\Qux         |
      | Foo\Qux\Baz\Foo | Foo\Qux\Baz\Foo\Baz |
      | Foo\Bar         | Foo\Qux\Baz\Foo\Baz |
      | Foo\Qux\Baz\Foo | Foo\Qux             |

  Scenario Outline: Spec is renamed
    Given "<src>" exists
    When I rename "<src>" to "<target>"
    Then "<targetSpec>" should exist
    And "<srcSpec>" should not exist

    Examples:
      | src             | target              | srcSpec                      | targetSpec                   |
      | Foo\Bar         | Foo\Baz             | spec\Foo\BarSpec             | spec\Foo\BazSpec             |
      | Foo\Bar\Baz     | Foo\Baz\Qux         | spec\Foo\Bar\BazSpec         | spec\Foo\Baz\QuxSpec         |
      | Foo\Qux\Baz\Foo | Foo\Qux\Baz\Foo\Baz | spec\Foo\Qux\Baz\FooSpec     | spec\Foo\Qux\Baz\Foo\BazSpec |
      | Foo\Bar         | Foo\Qux\Baz\Qux     | spec\Foo\BarSpec             | spec\Foo\Qux\Baz\QuxSpec     |
      | Foo\Qux\Baz\Foo | Foo\Qux             | spec\Foo\Qux\Baz\FooSpec     | spec\Foo\QuxSpec             |
