<?php declare(strict_types=1);

namespace App\Service;

use App\Model\Question;
use App\Repository\QuestionRepository;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ListQuestionService
{
    /** @var QuestionRepository */
    private $questionRepository;

    /** @var GoogleTranslate */
    private $googleTranslate;

    public function __construct(QuestionRepository $questionRepository, GoogleTranslate $googleTranslate)
    {
        $this->questionRepository = $questionRepository;
        $this->googleTranslate = $googleTranslate;
    }

    /**
     * @param string $lang
     *
     * @return Question[]
     */
    public function findAll(string $lang): array
    {
        $questions = $this->questionRepository->findAll();

        $this->googleTranslate->setSource('en');
        $this->googleTranslate->setTarget($lang);

        foreach ($questions as $question) {
            $question->setText($this->googleTranslate->translate($question->getText()));

            $choices = [];

            foreach ($question->getChoices() as $choice) {
                $choices[]['text'] = $this->googleTranslate->translate($choice['text']);
            }

            $question->setChoices($choices);
        }

        return $questions;
    }
}
