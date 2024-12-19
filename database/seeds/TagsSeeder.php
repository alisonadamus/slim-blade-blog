<?php


use Phinx\Seed\AbstractSeed;

class TagsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            ['name' => 'PHP'],
            ['name' => 'Slim Framework'],
            ['name' => 'Eloquent'],
            ['name' => 'JavaScript'],
            ['name' => 'HTML'],
            ['name' => 'CSS'],
            ['name' => 'Laravel'],
            ['name' => 'Slim'],
            ['name' => 'Web Development'],
            ['name' => 'Database'],
            ['name' => 'Backend'],
            ['name' => 'Frontend'],
        ];

        $this->table('tags')->insert($data)->saveData();
    }
}
