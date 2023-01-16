<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo'            => $this->faker->sentence(3),
            'portada'           => 'https://via.placeholder.com/150x200',
            'descripcion'       => $this->faker->sentence(6),
            'url'               => 'https://biblioteca.org.ar/libros/89819.pdf',
            'fecha_publicacion' => now(),
            'user_id'           => '1',
        ];
    }
}
