<?php

namespace App\Livewire\Students;

use App\Enums\TypeContacts;
use App\Models\Peoples;
use App\Models\Students\StudentContacts;
use Livewire\Component;

use Illuminate\Support\Str;

class StudentContact extends Component
{
    public $student;
    public $contacts;
    public $type;
    public $contact;
    public $parent;
    public $data;

    public function mount($id)
    {
        $this->student  = Peoples::find($id);
        $this->contacts = $this->student?->contacts->where('active', 1)->toArray();
    }
    public function render()
    {
        return view('livewire.students.student-contact', ['typeContacts' => TypeContacts::cases()]);
    }

    public function addRow()
    {
        $this->data =  StudentContacts::create([
            'active' => 1,
            'student_id' => $this->student->id,
            'code'      => Str::uuid(),
        ]);

        $this->contacts = $this->student?->contacts->where('active', 1)->toArray();
    }

    public function removeRow($id)
    {
        $contact = StudentContacts::find($id);
        $contact->delete();
        // $contact->save();

        $this->contacts = $this->student?->contacts->where('active', 1)->toArray();
    }
    public function updated($property)
    {
        if ($property === 'contact') {
            StudentContacts::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'contact' => $this->contact,
            ]);
        }
        if ($property === 'parent') {
            StudentContacts::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'parent' => $this->parent,
            ]);
        }
        if ($property === 'type') {
            StudentContacts::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'type' => $this->type,
            ]);
        }
    }
    public function updatedContacts($value, $fieldPath)
    {
        [$index, $field] = explode('.', $fieldPath);
        $contactData = $this->contacts[$index] ?? null;

        if (!$contactData || empty($contactData['id'])) return;

        // $rules = [
        //     'parent' => 'nullable|string|max:255',
        //     'type' => 'required|string',
        //     'contact' => 'required|string|in:email,mobile',
        // ];

        $this->validate([
            "contacts.$index.$field" => $rules[$field] ?? 'nullable',
        ]);

        StudentContacts::where('id', $contactData['id'])->update([
            $field => strtolower($value),
        ]);
    }
}
