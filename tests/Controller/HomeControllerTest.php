<?php

namespace App\Tests;

use App\Entity\Skill;
use App\Tests\Framework\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testItWorks()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function homeController_should_display_h1_content()
    {
        $skill = new Skill();
        $skill->setName('first_skill');
        $this->em->persist($skill);
        $this->em->flush();

        $this->visit('/');
        $this->crawler;

        $this->assertResponseIsSuccessful();
        
    }
}
