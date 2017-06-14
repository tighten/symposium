## CSRF Makes a Comeback ##
I have written or updated a large amount of tests to cover front-end testing of all forms. I hope I haven't overlooked anything. All tests are passing, except for one test marked as incomplete as I haven't found a solution to testing reCaptcha.

 * To test CSRF effectively, one has to enable CSRF testing on Tests. This can be done on line 61 of `Illuminate\Foundation\Http\Middleware\VerifyCsrfToken`.
 * Had to add a `{{ csrf_field }}` to the Login partial.

---

`PublicProfileTest@user_can_be_contacted_from_profile()`

I cannot get this test to pass working with reCaptcha. If I remove the Captcha stuff from the controller, the test passes.
---
#### Forms / Tests ####
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
| conferences/edit                | ConferenceTest@user_can_create_conference() | * | 
| conferences/create              | ConferenceTest@user_can_edit_conference() | * |
| oauth/authorization-form        | Api/OAuthTest | | 
| partials/log-in-form            | AccountTest/users_can_log_in() | |
| partials/sign-up-form           | AccountTest/users_can_sign_up() | |
| submissions post only           | SubmissionTest@user_can_submit_talks_via_http |  * |
| talks/create                    | TalkTest/user_can_create_a_talk() | * | 
| talks/edit                      | TalkTest@user_can_save_a_new_revision_of_a_talk() | * |