<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class FillDB
 * @package App\Console\Commands
 */
class FillDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fill-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var  $validatedData */
        $data = [
            'name' => 'apple',
            'email' => 'ap@apple.com',
            'password' => bcrypt('123456'),
        ];

        /** @var  $user */
        $user = User::create($data);

        Task::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        return $user->createToken('authToken')->accessToken;
    }
}
