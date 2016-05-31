Feature: Comment
  In order to comment a post
  As a logged user
  I need to be able to introduce a post title and body and click the "Comentar" button

  Rules:
  - I'm a logged user

  Scenario: Comment with a title
    Given I am logged as username "gabriel" with password "gabriel"
    When I try to surf to the "Home" tab
    And I try to comment the post with the title "Comment with a title"
    Then I should see the comment error message "The comment precises body"

  Scenario: Comment with a body
    Given I am logged as username "jose" with password "jose"
    When I try to surf to the "Home" tab
    And I try to comment the post with the body "Comment with a body"
    Then I should see the comment error message "The comment precises title"

  Scenario: Comment with a title and a body
    Given I am logged as username "123456" with password "123456"
    When I try to surf to the "Home" tab
    And I try to comment the post with the title "Comment with a title and a body" and the body "Body of the comment with a title and a body"
    Then I should see the comment with the title "Comment with a title and a body"

  Scenario: Delete a post
    Given I am logged as username "123456" with password "123456"
    When I try to surf to the "Home" tab
    And I commented with the title "Comment with a title and a body" and the body "Body of the comment with a title and a body"
    And I try to delete the post with title "Comment with a title and a body"
    Then I should not see the post with title "Comment with a title and a body"

