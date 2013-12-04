Feature: Check User Administration Functionalities
	In order to determine the administration functionality of other users by an admin.

    Background:
        Given I am logged in as "admin"
        And there are following users defined:
          | name  | email          | password | activated | banned | role             |
		  | admin | admin@foo.com  | root     | 1         | 0      | ROLE_SUPER_ADMIN |
          | user1 | user1@foo.com  | root     | 1         | 0      | ROLE_USER        |
		  | user2 | user2@foo.com  | root     | 1         | 0      | ROLE_USER        |
		  | user3 | user3@foo.com  | root     | 1         | 0      | ROLE_USER        |
		  | user4 | user4@foo.com  | root     | 0         | 1      | ROLE_USER        |

	Scenario: list members for administration
        Given I am on "/en/admin/members"
		And I should see "user1"
		And I should see "user1@foo.com"
		And I should see "user2"
		And I should see "user2@foo.com"
		And I should see "user3"
		And I should see "user3@foo.com"
		And I should see "user4"
		And I should see "user4@foo.com"
		And I follow "User2"
		And I should see "ROLE_USER"
		And I should see "Change Roles"
		And I should see "Edit Account"

	Scenario: I modify a users roles
        Given I am on "/en/admin/members"
		And I should see "user1"
		And I should see "user1@foo.com"
		And I follow "User1"
		And I should see "ROLE_USER"
		And I should not see "ROLE_MODERATOR"
		And I follow "Change Roles"
		And I check "ROLE_MODERATOR"
		And I press "Update"
		And I should see "ROLE_USER"
		And I should see "ROLE_MODERATOR"

	Scenario: I modify a users account details
        Given I am on "/en/admin/members"
		And I should see "user1"
		And I should see "user1@foo.com"
		And I follow "User1"
		And I should see "User1"
		And I should see "user1@foo.com"
		And I follow "Edit Account"
		And I fill in "UpdateAccount[username]" with "userfoo"
		And I fill in "UpdateAccount[email]" with "bar@foo.com"
		And I press "Update"
		And I should see "userfoo"
		And I should see "bar@foo.com"

	Scenario: I deactivate a users account
        Given I am on "/en/admin/members"
		And I should see "user3"
		And I should see "user3@foo.com"
		And I follow "User3"
		And I should see "User3"
		And I should see "user3@foo.com"
		And I should see "Activated"
		And I follow "Deactivate"
		And I should see "Pending"

	Scenario: I activate a users account
        Given I am on "/en/admin/members"
		And I should see "user4"
		And I should see "user4@foo.com"
		And I follow "User4"
		And I should see "User4"
		And I should see "user4@foo.com"
		And I should see "Pending"
		And I follow "Activate"
		And I should see "Activated"

	Scenario: I ban a users account
        Given I am on "/en/admin/members"
		And I should see "user3"
		And I should see "user3@foo.com"
		And I follow "User3"
		And I should see "User3"
		And I should see "user3@foo.com"
		And the user should not be banned
		And I "ban" the user
		And the user should be banned

	Scenario: I unban a users account
        Given I am on "/en/admin/members"
		And I should see "user4"
		And I should see "user4@foo.com"
		And I follow "User4"
		And I should see "User4"
		And I should see "user4@foo.com"
		And the user should be banned
		And I "unban" the user
		And the user should not be banned

