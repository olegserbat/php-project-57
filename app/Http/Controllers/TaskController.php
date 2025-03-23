<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $selected = [
            'created_by_id' => '',
            'status_id' => '',
            'assigned_to_id' => '',
            'created_by_name' => 'Автор',
            'status_name' => 'Статус',
            'assigned_to_name' => 'Исполнитель'
        ];
        $tasks = DB::table('tasks')
            ->leftJoin('users', 'tasks.created_by_id', '=', 'users.id')
            //->leftJoin('users', 'tasks.assigned_to_id', '=', 'users.id')
            ->leftJoin('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select('tasks.id',
                'task_statuses.name as taskStatusesName',
                'tasks.name as tasksName',
                'users.name as creatorName',
                'users.name as assignedName', // не работает
                'tasks.created_at',
                'tasks.created_by_id',
                'tasks.status_id',
                'tasks.assigned_to_id'
            )->get();
        $statuses = $tasks->unique('taskStatusesName');
        $creators = $tasks->unique('creatorName');
        $assigneds = $tasks->unique('assignedName');
        if (isset($filter)) {
            $creatorID = $filter['created_by_id'];
            $statusID = $filter['status_id'];
            $assignedID = $filter['assigned_to_id'];
            $tasks = DB::table('tasks')
                ->leftJoin('users', 'tasks.created_by_id', '=', 'users.id')
                ->leftJoin('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
                ->select('tasks.id',
                    'task_statuses.name as taskStatusesName',
                    'tasks.name as tasksName',
                    'users.name as creatorName',
                    'users.name as assignedName',
                    'tasks.created_at',
                    'tasks.created_by_id',
                    'tasks.status_id',
                    'tasks.assigned_to_id'
                )->when($creatorID, function ($tasks, string $creatorID) {
                    $tasks->where('tasks.created_by_id', $creatorID);
                })->when($statusID, function ($tasks, string $statusID) {
                    $tasks->where('tasks.status_id', $statusID);
                })->when($assignedID, function ($tasks, string $assignedID) {
                    $tasks->where('tasks.assigned_to_id', $assignedID);
                })
                ->get();
            $selected['created_by_name'] = is_null($creatorID) ? 'Автор' : $tasks->filter(function ($item) use ($creatorID) {
                return $item->created_by_id == $creatorID;
            })->value('creatorName');
            $selected[''] = is_null($statusID) ? 'Статус' : $tasks->filter(function ($item) use ($statusID) {
                return $item->status_id == $statusID;
            })->value('taskStatusesName');
            $selected['assigned_to_name'] = is_null($assignedID) ? 'Исполнитель' : $tasks->filter(function ($item) use ($assignedID) {
                return $item->assigned_to_id == $assignedID;
            })->value('assignedName');
            $selected['created_by_id'] = $creatorID;
            $selected['status_id'] = $statusID;
            $selected['assigned_to_id'] = $assignedID;


//            foreach ($filter as $keyFilter => $item) {
//                if ($item !== null) {
//
//                    $tasks = $tasks->filter(function ($value) use ($keyFilter, $item) {
//                        return $value->$keyFilter == $item;
//                    });
//                }
//            }
        }
        return view('/tasks', [
            'tasks' => $tasks,
            'statuses' => $statuses,
            'creators' => $creators,
            'assigneds' => $assigneds,
            'selected' => $selected
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
            'description' =>'nullable',
            'assigned_to_id' => 'nullable'
        ]);
        $data = $request->input();
        $task = new Task();
        $task->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'status_id' => $data['status_id'],
            'created_by_id' => $createdById,
            'assigned_to_id' => $data['assigned_to_id']
        ]);
        $task->save();
        $request->session()->flash('status', 'Задача успешно создана');
        return redirect()
            ->route('tasks.index');
    }
}
