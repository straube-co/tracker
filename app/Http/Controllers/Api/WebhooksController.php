<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                $count = \App\Project::where('id', $event->resource)->count();
                $project = $client->projects->findById($event->resource);

                if ($count === 0) {
                    Project::create([
                        'id' => $project->id,
                        'name' => $project->name,
                    ]);
                }
            }
            elseif ($event->type === "task") {
                $count = \App\Task::where('id', $event->resource)->count();
                $task = $client->tasks->findById($event->resource);
                $project = $client->tasks->projects($task->id)[0];

                if ($count === 0) {
                    Task::create([
                        'id' => $task->id,
                        'name' => $task->name,
                        'project_id' => $project->id,
                    ]);
                }
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
