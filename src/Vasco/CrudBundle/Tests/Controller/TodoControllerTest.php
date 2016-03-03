<?php

namespace Vasco\CrudBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'todos');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'todolist');
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'todocreate');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'todoedit');
    }

    public function testDetails()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'tododetails');
    }

}
