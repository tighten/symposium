<?php

namespace Tests\Unit;

use App\Mail\ContactRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactRequestTest extends TestCase
{
    #[Test]
    public function rendering_the_mailer(): void
    {
        $mail = new ContactRequest(
            email: 'vader@empire.com',
            name: 'Darth Vader',
            userMessage: 'I am your father',
        );

        $message = $mail->render();

        $this->assertStringContainsString('vader@empire.com', $message);
        $this->assertStringContainsString('Darth Vader', $message);
        $this->assertStringContainsString('I am your father', $message);
    }
}
