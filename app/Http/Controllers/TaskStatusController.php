<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::paginate(15);
        return view('task_statuses.task_statuses', ['taskStatuses' => $taskStatuses]);
    }

    public function create()
    {
        return view('task_statuses.task_statuses_create');
    }

    public function store(StoreTaskStatusRequest $request)
    {
        $data = $request->validated();
        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();
        $request->session()->flash('status', 'Статус успешно создан');
        return redirect()
            ->route('task_status.index');
    }

    public function edit($id)
    {
        $taskStatus = TaskStatus::findOrFail($id);
        return view('task_statuses.task_statuses_edit', ['taskStatus' => $taskStatus]);
    }

    public function update(UpdateTaskStatusRequest $request, $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);
        $data = $request->validate([
            'name' => [
                'required',
                'max:255'
                ]
        ]);
        $taskStatus->fill($data);
        $taskStatus->save();
        $request->session()->flash('status', 'Статус успешно изменён');
        return redirect()
            ->route('task_status.index');
    }

    public function destroy(Request $request, $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);
        $tasks = $taskStatus->tasks;
        $tasks = $tasks->toArray();
        if ($taskStatus and !$tasks) {
            $taskStatus->delete();
            $request->session()->flash('status', 'Статус успешно удалён');
        } else {
            $request->session()->flash('alert', 'Не удалось удалить статус');
        }
        return redirect()
            ->route('task_status.index');
    }
}
