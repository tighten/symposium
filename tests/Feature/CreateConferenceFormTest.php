<?php

namespace Tests\Feature;

use App\Exceptions\ValidationException;
use App\Models\Conference;
use App\Models\User;
use App\Services\CreateConferenceForm;
use DateTime;
use Tests\IntegrationTestCase;

class CreateConferenceFormTest extends IntegrationTestCase
{
    /** @test */
    function conference_title_is_required()
    {
        $this->withoutExceptionHandling();

        $input = [
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('title', $e);

            return;
        }

        $this->validationErrorNotThrown('title');
    }

    /** @test */
    function conference_description_is_required()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'url' => 'http://example.com',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('description', $e);

            return;
        }

        $this->validationErrorNotThrown('description');
    }

    /** @test */
    function conference_url_is_required()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('url', $e);

            return;
        }

        $this->validationErrorNotThrown('url');
    }

    /** @test */
    function conference_start_date_must_be_a_valid_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => 'potato',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('starts_at', $e);

            return;
        }

        $this->validationErrorNotThrown('starts_at');
    }

    /** @test */
    function conference_end_date_must_be_a_valid_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'ends_at' => 'potato',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('ends_at', $e);

            return;
        }

        $this->validationErrorNotThrown('ends_at');
    }

    /** @test */
    function conference_end_date_must_not_be_before_start_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-01',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('ends_at', $e);

            return;
        }

        $this->validationErrorNotThrown('ends_at');
    }

    /** @test */
    function conference_can_be_a_single_day_conference()
    {
        $conferenceCount = Conference::count();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-04',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $form->complete();

        $this->assertCount($conferenceCount + 1, Conference::all());
    }

    /** @test */
    function conference_cfp_start_date_must_be_a_valid_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => 'potato',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('cfp_starts_at', $e);

            return;
        }

        $this->validationErrorNotThrown('cfp_starts_at');
    }

    /** @test */
    function conference_cfp_end_date_must_be_a_valid_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_ends_at' => 'potato',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('cfp_ends_at', $e);

            return;
        }

        $this->validationErrorNotThrown('cfp_ends_at');
    }

    /** @test */
    function conference_cfp_end_date_must_not_be_before_cfp_start_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => '2015-01-18',
            'cfp_ends_at' => '2015-01-15',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('cfp_ends_at', $e);

            return;
        }

        $this->validationErrorNotThrown('cfp_ends_at');
    }

    /** @test */
    function conference_cfp_start_date_must_be_before_the_conference_start_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_starts_at' => '2015-02-06',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('cfp_starts_at', $e);

            return;
        }

        $this->validationErrorNotThrown('cfp_starts_at');
    }

    /** @test */
    function conference_cfp_end_date_must_be_before_the_conference_start_date()
    {
        $this->withoutExceptionHandling();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_ends_at' => '2015-02-06',
        ];

        try {
            $form = CreateConferenceForm::fillOut($input, User::factory()->create());
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertHasError('cfp_ends_at', $e);

            return;
        }

        $this->validationErrorNotThrown('cfp_ends_at');
    }

    /** @test */
    function it_creates_a_conference_with_the_minimum_required_input()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $form->complete();

        $conference = Conference::first();
        $this->assertEquals('AwesomeConf 2015', $conference->title);
        $this->assertEquals('The best conference in the world!', $conference->description);
        $this->assertEquals('http://example.com', $conference->url);
    }

    /** @test */
    function conference_dates_are_saved_if_provided()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-01',
            'ends_at' => '2015-02-04',
            'cfp_starts_at' => '2015-01-15',
            'cfp_ends_at' => '2015-01-18',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $form->complete();

        $conference = Conference::first();
        $this->assertEquals(new DateTime('2015-02-01'), $conference->starts_at);
        $this->assertEquals(new DateTime('2015-02-04'), $conference->ends_at);
        $this->assertEquals(new DateTime('2015-01-15'), $conference->cfp_starts_at);
        $this->assertEquals(new DateTime('2015-01-18'), $conference->cfp_ends_at);
    }

    /** @test */
    function conference_cfp_url_is_saved_if_provided()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_url' => 'http://example.com/cfp',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $form->complete();

        $conference = Conference::first();
        $this->assertEquals('http://example.com/cfp', $conference->cfp_url);
    }

    /** @test */
    function empty_dates_are_treated_as_null()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '',
            'ends_at' => '',
            'cfp_starts_at' => '',
            'cfp_ends_at' => '',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $form->complete();

        $conference = Conference::first();
        $this->assertNull($conference->starts_at);
        $this->assertNull($conference->ends_at);
        $this->assertNull($conference->cfp_starts_at);
        $this->assertNull($conference->cfp_ends_at);
    }

    /** @test */
    function error_messages_are_available_if_creating_a_conference_fails()
    {
        $form = CreateConferenceForm::fillOut([], User::factory()->create());

        try {
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertNotEmpty($e->errors());
        }
    }

    /** @test */
    function completing_a_form_returns_the_new_conference()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, User::factory()->create());
        $conference = $form->complete();

        $this->assertInstanceOf(Conference::class, $conference);
        $this->assertNotNull($conference->id);
    }
}
