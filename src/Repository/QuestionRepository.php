<?php declare(strict_types=1);

namespace App\Repository;

use App\DataSource\DataSourceInterface;
use App\Model\Question;

class QuestionRepository
{
    /** @var DataSourceInterface */
    private $dataSource;

    public function __construct(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @return Question[]
     */
    public function findAll(): array
    {
        $questionsData = $this->dataSource->findAll();
        $questions = [];

        foreach ($questionsData as $questionData) {
            $questions[] = new Question($questionData['text'], $questionData['createdAt'], $questionData['choices']);
        }

        return $questions;
    }

    public function add(Question $question): void
    {
        $this->dataSource->add($question);
    }
}
