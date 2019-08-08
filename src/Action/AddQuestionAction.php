<?php declare(strict_types=1);

namespace App\Action;

use App\Model\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddQuestionAction
{
    /** @var QuestionRepository */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $jsonContent = json_decode($request->getContent(), true);

        $question = Question::fromArray($jsonContent);

        $this->questionRepository->add($question);

        return new JsonResponse($question);
    }
}
