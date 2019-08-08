<?php declare(strict_types=1);

namespace App\Tests\Unit\DataSource;

use App\DataSource\CsvDataSource;
use App\Model\Question;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class CsvDataSourceTest extends TestCase
{
    /** @var CsvDataSource */
    private $subject;

    /** @var Filesystem */
    private $filesystem;

    protected function setUp()
    {
        parent::setUp();

        $this->filesystem = new Filesystem(new MemoryAdapter());

        $this->subject = new CsvDataSource($this->filesystem, 'file.csv');
    }

    public function testFindAll(): void
    {
        $this->filesystem->write('file.csv', file_get_contents(__DIR__ . '/../../resources/questions.csv'));

        $this->assertEquals(
            json_decode(file_get_contents(__DIR__ . '/../../resources/questions.json'), true),
            $this->subject->findAll()
        );
    }

    public function testAdd(): void
    {
        $question = new Question('My Question', '2019-01-01 00:00:00', [['text' => 'choice1']]);

        $this->filesystem->write('file.csv', '');

        $this->subject->add($question);

        $this->assertContains(
            '"My Question","2019-01-01 00:00:00",choice1',
            $this->filesystem->read('file.csv')
        );
    }
}
