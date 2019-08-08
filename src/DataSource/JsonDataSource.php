<?php declare(strict_types=1);

namespace App\DataSource;

use App\Model\Question;
use DateTime;
use League\Flysystem\FilesystemInterface;

class JsonDataSource implements DataSourceInterface
{
    /** @var FilesystemInterface */
    private $defaultStorage;

    /** @var string */
    private $jsonFilename;

    public function __construct(FilesystemInterface $defaultStorage, string $jsonFilename)
    {
        $this->defaultStorage = $defaultStorage;
        $this->jsonFilename = $jsonFilename;
    }

    public function findAll(): array
    {
        return json_decode($this->defaultStorage->read($this->jsonFilename), true);
    }

    public function add(Question $question): void
    {
        $currentData = $this->findAll();

        $currentData[] = [
            'text' => $question->getText(),
            'createdAt' => $question->createdAt->format(DateTime::ISO8601),
            'choices' => $question->getChoices()
        ];

        $this->defaultStorage->update($this->jsonFilename, json_encode($currentData));
    }
}
