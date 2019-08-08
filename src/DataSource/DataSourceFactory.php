<?php declare(strict_types=1);

namespace App\DataSource;

use InvalidArgumentException;

class DataSourceFactory
{
    /** @var string */
    private $dataSourceName;

    /** @var JsonDataSource */
    private $jsonDataSource;

    /** @var CsvDataSource */
    private $csvDataSource;

    public function __construct(string $dataSourceName, JsonDataSource $jsonDataSource, CsvDataSource $csvDataSource)
    {
        $this->dataSourceName = $dataSourceName;
        $this->jsonDataSource = $jsonDataSource;
        $this->csvDataSource = $csvDataSource;
    }

    public function create(): DataSourceInterface
    {
        switch ($this->dataSourceName) {
            case 'json':
                return $this->jsonDataSource;
                break;
            case 'csv':
                return $this->csvDataSource;
                break;
            default:
                throw new InvalidArgumentException(sprintf('Data source `%s` not found', $this->dataSourceName));
        }
    }
}
