<?php

namespace Tests\Unit;

use App\Models\Poster;
use PHPUnit\Framework\TestCase;

class PosterTest extends TestCase
{
    /**
     * Тест для проверки создания экземпляра модели Poster.
     *
     * @return void
     */
    public function test_can_create_poster_instance()
    {
        $poster = new Poster([
            'title' => 'Test Poster',
            'description' => 'This is a test poster.',
            'photos' => ['http://example.com/photo1.jpg'],
            'price' => 100.50,
        ]);

        $this->assertInstanceOf(Poster::class, $poster);
        $this->assertEquals('Test Poster', $poster->title);
        $this->assertEquals('This is a test poster.', $poster->description);
        $this->assertEquals(['http://example.com/photo1.jpg'], $poster->photos);
        $this->assertEquals(100.50, $poster->price);
    }

    /**
     * Тест для проверки валидации данных.
     *
     * @return void
     */
    public function test_poster_has_valid_data()
    {
        $poster = new Poster([
            'title' => 'Valid Poster',
            'description' => 'This is a valid test poster.',
            'photos' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'price' => 150.00,
        ]);

        $this->assertTrue(strlen($poster->title) <= 200);
        $this->assertTrue(strlen($poster->description) <= 1000);
        $this->assertTrue(is_array($poster->photos));
        $this->assertTrue(count($poster->photos) <= 3);
        $this->assertTrue(is_numeric($poster->price));
    }
}

