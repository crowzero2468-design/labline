<?php

use App\Controllers\Home;
use CodeIgniter\Test\CIUnitTestCase;

final class LoginPageTest extends CIUnitTestCase
{
    public function testHomeLoginViewRendersLoginForm(): void
    {
        $controller = new Home();
        $output = $controller->login();

        $this->assertStringContainsString('Welcome', $output);
        $this->assertStringContainsString('Sign in', $output);
        $this->assertStringContainsString('Sign up', $output);
    }
}
