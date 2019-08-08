<?php declare(strict_types=1);

namespace App\DataSource;

use App\Model\Question;

interface DataSourceInterface
{
    /**
     * @return array
     */
    public function findAll(): array;

    public function add(Question $question): void;
}
