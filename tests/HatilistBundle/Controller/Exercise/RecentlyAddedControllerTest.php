<?php
declare(strict_types=1);

namespace HatilistBundle\Tests\Controller\Exercise;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecentlyAddedControllerTest extends WebTestCase
{
    public function testRecentlyAddedView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recently-added');

        $this->assertContains('<h3>Recent toegevoegd</h3>', $client->getResponse()->getContent());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Meer over deze oefening")')->count()
        );
    }
}