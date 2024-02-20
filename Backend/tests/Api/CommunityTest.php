<?php

namespace App\Tests;

class CommunityTest extends AbstractTest
{
    //php bin/phpunit --verbose --testdox
    public function testAbstractClass(): void
    {
        $token = $this->getToken();
        
        $this->assertNotNull($token, 'Token was null');
        $this->assertEquals(68, strlen($token), 'Token length wasn\'t 68 characters long');
    }
}
