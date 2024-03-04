<?php

namespace App\Test\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/menu/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Menu::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Menu index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'menu[name]' => 'Testing',
            'menu[price]' => 'Testing',
            'menu[description]' => 'Testing',
            'menu[category]' => 'Testing',
            'menu[orders]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Menu();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCategory('My Title');
        $fixture->setOrders('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Menu');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Menu();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setDescription('Value');
        $fixture->setCategory('Value');
        $fixture->setOrders('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'menu[name]' => 'Something New',
            'menu[price]' => 'Something New',
            'menu[description]' => 'Something New',
            'menu[category]' => 'Something New',
            'menu[orders]' => 'Something New',
        ]);

        self::assertResponseRedirects('/menu/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getOrders());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Menu();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setDescription('Value');
        $fixture->setCategory('Value');
        $fixture->setOrders('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/menu/');
        self::assertSame(0, $this->repository->count([]));
    }
}
