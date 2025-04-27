<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class labelController extends Controller
{
    public function index()
    {
        $labels = Label::paginate(15);
        return view('labels.labels', ['labels'=>$labels]);
    }

    public function create()
    {
        return view('labels.labels_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        $label = new Label();
        $label->fill($data);
        $label->save();
        $request->session()->flash('labels', 'Метка успешно создана');
        return redirect()
            ->route('labels.index');
    }

    public function edit($id)
    {
        $label = Label::findOrFail($id);
        return view('labels.label_edit', ['label'=>$label]);
    }

    public function update(Request $request, $id)
    {
        $label = Label::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        $label->fill($data);
        $label->save();
        $request->session()->flash('labels', 'Метка успешно изменена');
        return redirect()
            ->route('labels.index');
    }

    public function destroy(Request $request, $id)
    {
        $label = Label::findOrFail($id);
        $tasks = $label->tasks->toArray();
        if($label AND !$tasks){
            $label->delete();
            $request->session()->flash('labels', 'Метка успешно удалена');
        } else {
            $request->session()->flash('alert', 'Не удалось удалить метку');
        }
        return redirect()
            ->route('labels.index');
    }
}
