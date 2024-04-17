Feature: Just a simple call to a php script

  @javascript
  Scenario: I am on a php and see the echo response
    And I am on "index.php"
    Then I should see "Huhuuu!"
