<?php
// tests/Controller/WelcomeControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WelcomeControllerTest extends WebTestCase
{
    /**
     * Test if the welcome page renders successfully.
     *
     * This test checks if a request to the root URL returns a valid response and
     * renders the base.html.twig template.
     */
    public function testWelcomePageRendersSuccessfully(): void
    {
        // Create a client to simulate a request to the application
        $client = static::createClient();

        // Make a request to the root URL ('/')
        $client->request('GET', '/');

        // Assert that the response status code is 200 (OK)
        $this->assertResponseIsSuccessful();

        // Assert that the response contains something specific to the base.html.twig template
        // For example, if the base template has a unique string or an element, we can check for it
        $this->assertSelectorTextContains('h1', 'fizz-buzz REST server');
    }
}
