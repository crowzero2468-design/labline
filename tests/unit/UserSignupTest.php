<?php

use CodeIgniter\Test\CIUnitTestCase;

final class UserSignupTest extends CIUnitTestCase
{
    public function testUserModelUsesTbUserTable(): void
    {
        $source = file_get_contents(APPPATH . 'Models/UserModel.php');

        $this->assertStringContainsString("protected \$table = 'tb_user';", $source);
        $this->assertStringContainsString("'fname'", $source);
        $this->assertStringContainsString("'uname'", $source);
    }
}
