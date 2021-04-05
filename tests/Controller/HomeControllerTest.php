<?php 

namespace App\Tests;

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
      
    $this->visit('/');
    $this->crawler;

    $this->assertResponseIsSuccessful();
    $this->assertElementTextContains('About Me', $this->crawler->filter('h2'));
        
    }

    
    
}