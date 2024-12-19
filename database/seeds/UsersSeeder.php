<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
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
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('users')->insert($data)->saveData();
    }
}
