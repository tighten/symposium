# CSRF Makes a Comeback #

| Form                            | Test Coverage                                                |
|---------------------------------|--------------------------------------------------------------|
| account/public-profile/email    | Unsure? |
| account/confirm-delete          | AccountTest/users_can_delete_their_accounts() |
| account/edit                    | No Test Coverage | 
| auth/passwords/email            | AccountTest/password_reset_emails_are_sent_for_valid_users() |
| auth/passwords/reset            | Dig deeper |
| bios/create                     | Covered by BioTest |
| bios/edit                       | Covered by BioTest |
| conferences/create              | Covered by CreateConferenceTestForm |
| conferences/edit                | No test coverage |
| oauth/authorization-form        | Not sure - dig deeper |
| partials/log-in-form            | AccountTest/users_can_log_in() |
| partials/sign-up-form           | AccountTest/users_can_sign_up() |
| talks/create                    | TalkTest/user_can_create_a_talk() |
| talks/edit                      | No Test Coverage |
| submissions??                   | Dig deeper |

| Form creation method | Times Used |
|----------------------|------------|
| Form::open           | 11         |
| Form::model          | 1          |
| html form            | 2          |
