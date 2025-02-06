<?php

namespace Database\Seeders;

use App\Actions\CreateUserAction;
use App\Data\UserDTO;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function __construct(protected CreateUserAction $action)
    {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/customers.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("JSON dosyası bulunamadı: {$jsonPath}");
            return;
        }

        $users = json_decode(file_get_contents($jsonPath), true);
        if (!$users) {
            $this->command->error("JSON formatı hatalı!");
            return;
        }

        try {
            foreach ($users as $user) {
                $explodedName = explode(' ', $user['name']);
                $dto = new UserDTO(
                    name: $explodedName[0],
                    last_name: $explodedName[1],
                    email: $this->createEmailForUser($user['name']),
                    password: '123456789'
                );

                $this->action->execute($dto);

            }
        } catch (\Exception $e) {
            $this->command->error("Hata: " . $e->getMessage());
        }
    }

    private function createEmailForUser(string $name): string
    {
        $explodedName = explode(' ', Str::lower($name));
        $firstName = Str::ascii($explodedName[0]);
        $lastName = Str::ascii($explodedName[1]);

        return strtolower("{$firstName}.{$lastName}@example.com");
    }

}
