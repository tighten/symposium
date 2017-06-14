# CSRF Makes a Comeback #

| Form                            | Test Coverage                                                | New |
|---------------------------------|--------------------------------------------------------------|-----|
| auth/passwords/reset            | AccountTest@password_reset_emails_are_sent_for_valid_users() | * |
| auth/passwords/email            | AccountTest@user_can_reset_their_password_from_email_link() | * |
| account/edit                    | AccountTest@user_can_update_their_profile() | * |
|                                 | AccountTest@user_can_update_their_profile_picture() | * |
| account/confirm-delete          | AccountTest@users_can_delete_their_accounts() | |
| account/public-profile/email    | PublicProfileTest@user_can_be_contacted_from_profile()  | ! |
| bios/create                     | Covered in BioTest | * |
| bios/edit                       | Covered in BioTest | * |
| conferences/edit                | ConferenceTest@user_can_create_conference() | | 
| conferences/create              | ConferenceTest@user_can_edit_conference() | * |
| oauth/authorization-form        | Api/OAuthTest | | 
| partials/log-in-form            | AccountTest/users_can_log_in() | |
| partials/sign-up-form           | AccountTest/users_can_sign_up() | |
| talks/create                    | TalkTest/user_can_create_a_talk() | | 
| talks/edit                      | TalkTest@user_can_save_a_new_revision_of_a_talk() |

| Form creation method | Times Used |
|----------------------|------------|
| Form::open           | 11         |
| Form::model          | 1          |
| html form            | 2          |
