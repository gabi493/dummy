Feature: Menu
  In order to surf the menu
  As a logged user
  I need to be able to change from one page to another

  Rules:
  - I'm a logged user

#  @javascript
  Scenario: Surf to the "Home" tab
    Given I am logged as username "gabriel" with password "gabriel"
    When I try to surf to the "Home" tab
    Then I should see the post title "Un título para el anuncio de la empresa."

  Scenario: Surf to the "About us" tab
    Given I am logged as username "jose" with password "jose"
    When I try to surf to the "About us" tab
    Then I should see the welcome title "Welcome jose!"

  Scenario: Surf to the "Exit" tab
    Given I am logged as username "123456" with password "123456"
    When I try to surf to the "Exit" tab
    Then I should see the button "Login"


