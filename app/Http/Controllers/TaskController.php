<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        //return json_encode(DB::table('tasks')->count(), JSON_UNESCAPED_UNICODE);
        $filterStart = [
            'created_by_id' => '',
            'status_id' => '',
            'assigned_to_id' => ''
        ];
        $filterRequest = ($request->input('filter') !== null) ? $request->input('filter') : [];
        $filter = array_merge($filterStart, $filterRequest);
        $users = User::all()->unique();
        $statuses = TaskStatus::all()->unique();
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                [
                    AllowedFilter::exact('status_id'),
                    AllowedFilter::exact('created_by_id'),
                    AllowedFilter::exact('assigned_to_id')
                ]
            )
            ->orderBy('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('tasks.tasks', [
            'tasks' => $tasks,
            'statuses' => $statuses,
            'users' => $users,
            'filter' => $filter
        ]);
    }

    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('tasks.tasks_create', ['statuses' => $statuses, 'users' => $users, 'labels' => $labels]);
    }

    public function store(StoreTaskRequest $request)
    {
        $createdById = auth()->user()->id;
        $data = $request->validated();
        $task = new Task();
        $task->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'status_id' => $data['status_id'],
            'created_by_id' => $createdById,
            'assigned_to_id' => $data['assigned_to_id'],
        ]);
        DB::transaction(function () use ($task, $data) {
            $task->save();
            if (isset($data['labels'])) {
                $task->labeles()->attach($data['labels']);
            }
        });
        $request->session()->flash('task', 'Задача успешно создана');
        return redirect()
            ->route('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = TaskStatus::all();
        $users = User::all();
        $allLabels = Label::all();
        return view('tasks.task_edit', ['task' => $task,
            'statuses' => $statuses,
            'users' => $users,
            'allLabels' => $allLabels,
        ]);
    }

    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->validated();
        $task->fill($data);
        DB::transaction(function () use ($task, $data) {
            $task->save();
            if (isset($data['labels'])) {
                $task->labeles()->sync($data['labels']);
            } else {
                $task->labeles()->detach();
            }
        });
        $request->session()->flash('task', 'Задача успешно изменена');
        return redirect()
            ->route('tasks.index');
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        $request->session()->flash('task', 'Задача успешно удалена');
        return redirect()
            ->route('tasks.index');
    }


    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.task_show', ['task' => $task]);
    }
}
