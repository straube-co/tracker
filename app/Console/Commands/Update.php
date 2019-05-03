<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Task;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Update extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $client;

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
     * @return mixed
     */
    public function handle()
    {
        $this->info("Building!");

        $client = $this->getClient();
        $projects = $client->projects->findByWorkspace(870874468980849);

        foreach ($projects as $project) {
            $count = \App\Project::where('id', $project->id)->count();

            if ($count === 0) {
                Project::create([
                    'id' => $project->id,
                    'name' => $project->name,
                ]);
            }

            $this->importTasks($project);
        }
    }

    public function importTasks($project)
    {
        $client = $this->getClient();
        $tasks = $client->tasks->findByProject($project->id);

        foreach ($tasks as $task) {
            $count = \App\Task::where('id', $task->id)->count();

            if ($count === 0) {
                Task::create([
                    'id' => $task->id,
                    'name' => $task->name,
                    'project_id' => $project->id,
                ]);
            }
        }
    }

    public function getClient()
    {
        if (!isset($this->client)) {
            $this->client = \Asana\Client::accessToken('0/b41a58e0103d856760d375e247e8dd13');
        }
        return $this->client;
    }
}
