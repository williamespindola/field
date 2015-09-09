Feature: collections
    In order create collections
    As a terminal user
    I need to be able to create n collections as I want

Scenario: Create a collection
    Given I am in a directory "./"
    When I run "./bin/field create -c field.config.php Collection about About"
    Then I should see "Collection about was been created."