<?php declare(strict_types=1);

namespace App\Service;

use App\Model\Question;
use App\Repository\QuestionRepository;

class AddQuestionService
{
    /** @var QuestionRepository */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function add(Question $question): void
    {
        $this->questionRepository->add($question);
    }
}
