<?php

use Laracasts\TestDummy\Factory;
use Symposium\Exceptions\ValidationException;
use Symposium\Services\CreateConferenceForm;

class CreateConferenceFormTest extends IntegrationTestCase
{
    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_title_is_required()
    {
        $input = [
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_description_is_required()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_url_is_required()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_start_date_must_be_a_valid_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => 'potato',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_end_date_must_be_a_valid_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'ends_at' => 'potato',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_end_date_must_not_be_before_start_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-01',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_cfp_start_date_must_be_a_valid_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => 'potato',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_cfp_end_date_must_be_a_valid_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_ends_at' => 'potato',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_cfp_end_date_must_not_be_before_cfp_start_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => '2015-01-18',
            'cfp_ends_at' => '2015-01-15',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_cfp_start_date_must_be_before_the_conference_start_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_starts_at' => '2015-02-06',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     * @expectedException Symposium\Exceptions\ValidationException
     */
    public function conference_cfp_end_date_must_be_before_the_conference_start_date()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_ends_at' => '2015-02-06',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();
    }

    /**
     * @test
     */
    public function it_creates_a_conference_with_the_minimum_required_input()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();

        $conference = Conference::first();
        $this->assertEquals('AwesomeConf 2015', $conference->title);
        $this->assertEquals('The best conference in the world!', $conference->description);
        $this->assertEquals('http://example.com', $conference->url);
    }

    /**
     * @test
     */
    public function conference_dates_are_saved_if_provided()
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

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();

        $conference = Conference::first();
        $this->assertEquals(new DateTime('2015-02-01'), $conference->starts_at);
        $this->assertEquals(new DateTime('2015-02-04'), $conference->ends_at);
        $this->assertEquals(new DateTime('2015-01-15'), $conference->cfp_starts_at);
        $this->assertEquals(new DateTime('2015-01-18'), $conference->cfp_ends_at);
    }

    /**
     * @test
     */
    public function empty_dates_are_treated_as_null()
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

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $form->complete();

        $conference = Conference::first();
        $this->assertNull($conference->starts_at);
        $this->assertNull($conference->ends_at);
        $this->assertNull($conference->cfp_starts_at);
        $this->assertNull($conference->cfp_ends_at);
    }

    /**
     * @test
     */
    public function error_messages_are_available_if_creating_a_conference_fails()
    {
        $form = CreateConferenceForm::fillOut([], Factory::create('user'));

        try {
            $form->complete();
        } catch (ValidationException $e) {
            $this->assertNotEmpty($e->errors());
        }
    }

    /**
     * @test
     */
    public function completing_a_form_returns_the_new_conference()
    {
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $form = CreateConferenceForm::fillOut($input, Factory::create('user'));
        $conference = $form->complete();

        $this->assertInstanceOf(Conference::class, $conference);
        $this->assertNotNull($conference->id);
    }
}
