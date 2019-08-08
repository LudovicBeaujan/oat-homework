<?php declare(strict_types=1);

namespace App\Model;

use DateTime;
use JsonSerializable;

class Question implements JsonSerializable
{
    /** @var string */
    public $text;

    /** @var DateTime */
    public $createdAt;

    /** @var string[] */
    public $choices = [];

    public function __construct(string $text, string $createdAt, array $choices)
    {
        $this->text = $text;
        $this->createdAt = new DateTime($createdAt);
        $this->choices = $choices;
    }

    public static function fromArray(array $data): Question
    {
        return new self($data['text'], $data['createdAt'], $data['choices']);
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setChoices(array $choices): self
    {
        $this->choices = $choices;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function jsonSerialize()
    {
        return [
            'text' => $this->text,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'choices' => $this->choices
        ];
    }
}
