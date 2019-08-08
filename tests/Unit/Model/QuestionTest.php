<?php declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\Question;
use DateTime;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function testCreateFromArray(): void
    {
        $data = [
            'text' => 'My question',
            'createdAt' => '2018-02-02 00:00:00',
            'choices' => ['choice1']
        ];

        $question = Question::fromArray($data);

        $this->assertEquals('My question', $question->getText());
        $this->assertEquals(new DateTime('2018-02-02 00:00:00'), $question->getCreatedAt());
        $this->assertEquals(['choice1'], $question->getChoices());
    }

    public function testJsonSerialize(): void
    {
        $data = [
            'text' => 'My question',
            'createdAt' => '2018-02-02 00:00:00',
            'choices' => ['choice1']
        ];

        $question = Question::fromArray($data);

        $this->assertEquals($data, $question->jsonSerialize());
    }
}
