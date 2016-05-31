Feature: Sign up
  In order to sign up
  As a new user
  I need to be able to provide the necessary information to the system

  Rules:
  - Mail contains an @
  - Username with > 6 characters
  - Password with > 6 characters
  - Mail not containing an @ returns error "Insert a valid e-mail: must contain an @"
  - Username with <= 5 characters returns error "Insert a valid username: must contain at least 6 characters"
  - Password with <= 5 characters returns error "Insert a valid password: must contain at least 6 characters"

  Scenario: Sign up to the system with an invalid e-mail
    Given I am not registered
    When I try to "sign" to the system with an e-mail not containing an @
    Then I should see the signup error message "Invalid e-mail format"

  Scenario: Sign up to the system with an invalid username
    Given I am not registered
    When I try to "sign" to the system with a username shorter than 6 characters
    Then I should see the signup error message "Username must be at least 6 characters long"

  Scenario: Sign up to the system with an invalid password
    Given I am not registered
    When I try to "sign" to the system with a password shorter than 6 characters
    Then I should see the signup error message "Password must be at least 6 characters long"

  Scenario: Sign up to the system without some of the required data
    Given I am not registered
    When I try to "sign" to the system without an e-mail, username or password
    Then I should see the signup error message "Fill in all the fields"

