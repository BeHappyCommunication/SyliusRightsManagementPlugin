@managing_groups
  Feature: Adding a new group
    In order to administrate groups
    As an administrator
    I want to add a new group

  Background:
    Given I am logged in as an administrator

  @ui
  Scenario: Adding group
    When I want to add a new group
    And I choose "Administrators"
    Then I add it
    Then I should be notified it has been successfully created
    And the group "Administrators" should appear in the store
