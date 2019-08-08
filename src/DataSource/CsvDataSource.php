<?php declare(strict_types=1);

namespace App\DataSource;

use App\Model\Question;
use DateTime;
use League\Csv\Writer;
use League\Flysystem\FilesystemInterface;
use League\Csv\Reader;

class CsvDataSource implements DataSourceInterface
{
    /** @var FilesystemInterface */
    private $defaultStorage;

    /** @var string */
    private $csvFilename;

    public function __construct(FilesystemInterface $defaultStorage, string $csvFilename)
    {
        $this->defaultStorage = $defaultStorage;
        $this->csvFilename = $csvFilename;
    }

    public function findAll(): array
    {
        $reader = Reader::createFromString($this->defaultStorage->read($this->csvFilename));

        $reader->setHeaderOffset(0);

        $mappedQuestions = [];

        foreach ($reader->jsonSerialize() as $question) {
            $mappedQuestions[] = [
                'text' => $question['Question text'],
                'createdAt' => $question['Created At'],
                'choices' => [
                    ['text' => $question['Choice 1']],
                    ['text' => $question['Choice']],
                    ['text' => $question['Choice 3']],
                ]
            ];
        }

        return $mappedQuestions;
    }

    public function add(Question $question): void
    {
        $writer = Writer::createFromString($this->defaultStorage->read($this->csvFilename), 'w+');

        $writer->insertOne($this->questionToArray($question));

        $this->defaultStorage->update($this->csvFilename, $writer->getContent());
    }

    private function questionToArray(Question $question): array
    {
        $choices = [];

        foreach ($question->getChoices() as $choice) {
            $choices[] = $choice['text'];

        }

        return array_merge(
            [
                $question->getText(),
                $question->getCreatedAt()->format('Y-m-d H:i:s'),
            ],
            $choices
        );
    }
}
