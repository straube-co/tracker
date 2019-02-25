<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;

class WebhooksController extends Controller
{
    private $client;

    public function receiving() {
        $request = request();

        $handshake = $request->header('X-Hook-Secret');
        if ($handshake) {
            return \response('', 200, [
                'X-Hook-Secret' => $handshake,
            ]);
        }

        $client = $this->getClient();
        $events = $request->events;

        foreach ($events as $event) {
            $event = (object) $event;

            if ($event->type === "project") {
                $project = $client->projects->findById($event->resource);

                Project::create([
                    'id' => $project->id,
                    'name' => $project->name,
                ]);
            }
            elseif ($event->type === "task") {
                $task = $client->tasks->findById($event->resource);
                $project = $client->tasks->projects($task->id)[0];

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
