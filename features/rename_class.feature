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
      | src     | target  |
      | Foo\Bar | Foo\Baz |

  Scenario Outline: Spec is renamed
    Given "<src>" exists
    When I rename "<src>" to "<target>"
    Then "<targetSpec>" should exist
    And "<srcSpec>" should not exist

    Examples:
      | src     | target  | srcSpec          | targetSpec       |
      | Foo\Bar | Foo\Baz | spec\Foo\BarSpec | spec\Foo\BazSpec |
