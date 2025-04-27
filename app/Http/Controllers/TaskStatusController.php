<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::paginate(15);
        return view('task_statuses.task_statuses', ['taskStatuses'=>$taskStatuses]);
    }

    public function create()
    {
        return view('task_statuses.task_statuses_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
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
        return view('task_statuses.task_statuses_edit', ['taskStatus'=>$taskStatus]);
    }

    public function update(Request $request, $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);
        $data = $request->validate([
            'name' => "required",
        ]);
        $taskStatus->fill($data);
        $taskStatus->save();
        $request->session()->flash('status', 'Статус успешно изменен');
        return redirect()
            ->route('task_status.index');
    }

    public function destroy(Request $request, $id)
    {
        $taskStatus = TaskStatus::findOrFail($id);
        if($taskStatus){
            $taskStatus->delete();
            $request->session()->flash('status', 'Статус успешно удален');
        }
        return redirect()
            ->route('task_status.index');
    }

}
