<?php declare(strict_types=1);

namespace App\Tests\Functional\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ListQuestionActionTest extends WebTestCase
{
    public function testItRetrievesAllQuestions(): void
    {
        $client = static::createClient();

        $client->request('GET', '/questions?lang=en');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(
            ['data' => json_decode(file_get_contents(__DIR__ . '/../../resources/questions.json'), true)],
            json_decode($client->getResponse()->getContent(), true)
        );
    }

    public function testItRetrievesAllQuestionsWithTranslation(): void
    {
        $client = static::createClient();

        $client->request('GET', '/questions?lang=fr');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(
            ['data' => json_decode(file_get_contents(__DIR__ . '/../../resources/questions_french.json'), true)],
            json_decode($client->getResponse()->getContent(), true)
        );
    }

    public function testItThrowsAnExceptionIfLanguageIsNotSpecified(): void
    {
        $client = static::createClient();

        $this->expectException(BadRequestHttpException::class);

        $client->request('GET', '/questions');
    }
}
