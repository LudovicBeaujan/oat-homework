<?php declare(strict_types=1);

namespace App\Tests\Unit\DataSource;

use App\DataSource\JsonDataSource;
use App\Model\Question;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class JsonDataSourceTest extends TestCase
{
    /** @var JsonDataSource */
    private $subject;

    /** @var Filesystem */
    private $filesystem;

    protected function setUp()
    {
        parent::setUp();

        $this->filesystem = new Filesystem(new MemoryAdapter());

        $this->subject = new JsonDataSource($this->filesystem, 'file.json');
    }

    public function testFindAll(): void
    {
        $this->filesystem->write('file.json', file_get_contents(__DIR__ . '/../../resources/questions.json'));

        $this->assertEquals(
            json_decode(file_get_contents(__DIR__ . '/../../resources/questions.json'), true),
            $this->subject->findAll()
        );
    }

    public function testAdd(): void
    {
        $question = new Question('My Question', '2019-01-01 00:00:00', ['choice1']);

        $this->filesystem->write('file.json', '[]');

        $this->subject->add($question);

        $this->assertEquals(
            json_encode([['text' => 'My Question', 'createdAt' => '2019-01-01T00:00:00+0100', 'choices' => ['choice1']]]),
            $this->filesystem->read('file.json')
        );
    }
}
