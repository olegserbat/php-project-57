<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request)
    {
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
            ->map(function ($item) use ($users, $statuses) {
                $item->creatorName = $users->where('id', $item->created_by_id)->first()->name;
                $item->assignedName = $users->where('id', $item->assigned_to_id)->first()?->name;
                $item->taskStatusesName = $statuses->where('id', $item->status_id)->first()->name;
                return $item;
            });
        $userName = new User();
        $statusName = new TaskStatus();

        $filter['created_by_name'] = ($filter['created_by_id'] == '') ? 'Автор' :
            $userName->where('id', $filter['created_by_id'])->first()->name;
        $filter['assigned_to_name'] = ($filter['assigned_to_id'] == '') ? 'Исполнитель' :
            $userName->where('id', $filter['assigned_to_id'])->first()->name;
        $filter['status_name'] = ($filter['status_id'] == '') ? 'Статус' :
            $statusName->where('id', $filter['status_id'])->first()->name;

        return view('/tasks', [
            'tasks' => $tasks,
            'statuses' => $statuses,
            'users' => $users,
            'filter' => $filter
        ]);
    }

    public function create()
    {
        $statuses = DB::table('task_statuses')->select('id as status_id', 'name as status_name')->get();
        $users = DB::table('users')->select('id as user_id', 'name as user_name')->get();
        return view('tasks_create', ['statuses' => $statuses, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $createdById = auth()->user()->id;
        $data = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'description' => 'nullable',
            'assigned_to_id' => 'nullable'
        ]);
        //$data = $request->input();
        $task = new Task();
        $task->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'status_id' => $data['status_id'],
            'created_by_id' => $createdById,
            'assigned_to_id' => $data['assigned_to_id']
        ]);
        $task->save();
        $request->session()->flash('task', 'Задача успешно создана');
        return redirect()
            ->route('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $status = new TaskStatus();
        $task->statusName = $status->where('id', $task->status_id)->first()->name;
        $user = new User();
        $task->createdName = $user->where('id', $task->created_by_id)->first()->name;
        $task->assignedName = $task->assigned_to_id ? $user->where('id', $task->assigned_to_id)->first()->name : '';
        $statuses = TaskStatus::all();
        $users = User::all();

        return view('task_edit', ['task' => $task, 'statuses' => $statuses, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'description' => 'nullable',
            'assigned_to_id' => 'nullable'
        ]);
        $task->fill($data);
        $task->save();
        $request->session()->flash('task', 'Задача успешно изменена');
        return redirect()
            ->route('tasks.index');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task) {
            $task->delete();
        }
        return redirect()
            ->route('tasks.index');
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        $status = new TaskStatus();
        $task->statusName = $status->where('id', $task->status_id)->first()->name;
        return view('task_show', ['task' => $task]);
    }
}
