<?php

namespace App\Livewire\Category\TestMedical;

use Livewire\Component;
use App\Models\TestName;

class Index extends Component
{
    public $name, $description, $remarks, $id;

    public function rules()
    {
        return
        [
            'name' => ['required','string'],
            'description' => ['required','string'],
            'remarks' => ['nullable']
        ];
    }

    public function store()
    {
        $validateData = $this->validate();



        TestName::insert([
            'name'=>$validateData['name'],
            'description'=>$validateData['description'],
            'remarks'=>$validateData['remarks']
        ]);

        session()->flash('msg','Test Successfully Inserted');
        $this->dispatch('close-modal');
        $this->reset(['name','description','remarks']);
    }

    public function resetInput()
    {
        $this->reset(['name','description','remarks']);
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function openModal()
    {
        $this->resetInput();
    }

    public function edit($id)
    {
        $this->id = $id;
        $brands = TestName::findOrFail($id);
        $this->name = $brands->name;
        $this->description = $brands->description;
        $this->remarks = $brands->remarks;
    }

    
    public function update()
    {

        $validateData = $this->validate();

        TestName::where('id',$this->id)->update([
            'name'=>$validateData['name'],
            'description'=>$validateData['description'],
            'remarks'=>$validateData['remarks']
        ]);

        session()->flash('msg','Test Successfully Updated');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function delete($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        TestName::findOrFail($this->id)->delete();
        session()->flash('msg','Test Successfully Deleted');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $brands = TestName::latest()->get();
        return view('livewire.category.test-medical.index', get_defined_vars())
        ->extends('layouts.admin')
        ->section('main-content');
    }
}
