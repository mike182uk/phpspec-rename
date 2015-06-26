Feature: Rename class
  In order to improve my efficiency when renaming a class
  As a developer
  I want to be able to rename a class and its corresponding spec with PHPSpec

  Scenario: Class is renamed
    Given "Foo\Bar" exists
    When I rename "Foo\Bar" to "Foo\Baz"
    Then "Foo\Baz" should exist
    And "Foo\Bar" should not exist
