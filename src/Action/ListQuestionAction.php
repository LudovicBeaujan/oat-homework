<?php declare(strict_types=1);

namespace App\Action;

use App\Service\ListQuestionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ListQuestionAction
{
    /** @var ListQuestionService */
    private $listQuestionService;

    public function __construct(ListQuestionService $listQuestionService)
    {
        $this->listQuestionService = $listQuestionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $lang = $request->query->get('lang');

        if (!$lang) {
            throw new BadRequestHttpException('The parameter `lang` is mandatory.');
        }

        return new JsonResponse(['data' => $this->listQuestionService->findAll($lang)]);
    }
}
