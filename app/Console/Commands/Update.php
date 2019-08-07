<?php

namespace App\Console\Commands;

use App\Project;
use App\Task;
use Asana\Client;
use Illuminate\Console\Command;

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
        $this->info('Building!');

        $this->importProjects();
    }

    private function importProjects()
    {
        $client = $this->getClient();
        // Move the workspace ID to a config or wherever it fits better.
        $projects = $client->projects->findByWorkspace(870874468980849);

        foreach ($projects as $project) {
            Project::updateOrCreate([
                'id' => $project->id,
            ], [
                'name' => $project->name,
            ]);
            $this->importTasks($project);
        }
    }

    private function importTasks($project)
    {
        $client = $this->getClient();
        $tasks = $client->tasks->findByProject($project->id);

        foreach ($tasks as $task) {
            Task::updateOrCreate([
                'id' => $task->id,
            ], [
                'name' => substr($task->name, 0, 100),
                'project_id' => $project->id,
            ]);
        }
    }

    private function getClient()
    {
        if (!isset($this->client)) {
            // TODO: Move this token to a config or other place
            $this->client = Client::accessToken('0/b41a58e0103d856760d375e247e8dd13');
        }
        return $this->client;
    }
}
