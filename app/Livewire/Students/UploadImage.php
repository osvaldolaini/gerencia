<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UploadImage extends Component
{
    use WithFileUploads;

    public $uploadimage;
    public $student;
    public $photo;
    public $rules;

    public function mount($id)
    {
        if ($id) {
            $this->student = Peoples::find($id);
            $this->photo = Storage::directoryExists('public/student/' . $this->student->id);
        }
    }
    public function render()
    {
        return view('livewire.students.upload-image');
    }
    public function changePhoto()
    {
        $this->dispatch('submitForm');
    }
    public function updated($property)
    // public function uploadPhoto()
    {
        if ($property === 'uploadimage') {
            $this->rules = [
                'uploadimage'   => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ];

            $this->validate();
            if (Storage::directoryMissing('public/student/' . $this->student->id)) {
                Storage::makeDirectory('public/student/' . $this->student->id, 0755, true, true);
            }
            Storage::deleteDirectory('public/student/' . $this->student->id);

            if (isset($this->uploadimage)) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                $path = storage_path('app/public/student/' . $this->student->id);

                Storage::makeDirectory($path, 0755, true, true);

                $this->uploadimage->storeAs('public/student/' . $this->student->id, $new_name);
                $this->student->logo_path = $new_name;
                $this->student->save();

                $this->logo(
                    'Student/' . $this->student->id . '/' . $new_name,
                    $this->student->id,
                    $code
                );
            }
        }
    }
    public function excluirTemp()
    {
        $this->uploadimage = '';
    }
    public function excluirPhoto()
    {
        $this->student->logo_path = '';
        $this->student->save();
        if (Storage::directoryMissing('public/student/' . $this->student->id)) {
            Storage::makeDirectory('public/student/' . $this->student->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/student/' . $this->student->id);
        $this->photo = $this->student->logo_path;
    }
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    public static function logo($path, $id, $code)
    {
        $path = 'storage/' . $path;
        // dd($path);
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($path);
        // $image = ImageManager::imagick()->read('images/example.jpg');
        // save modified image in new format
        $image->toPng()->save('storage/student/' . $id . '/' . $code . '_small.png');
        // $image->toWebp()->save('storage/student/' . $id . '/' . $code . '_small.webp');
        $image->scale(width: 200);
        $image->toPng()->save('storage/student/' . $id . '/' . $code . '_big.png');
        // $image->toWebp()->save('storage/student/' . $id . '/' . $code . '_big.webp');
        $image->scale(width: 300);
        // List
        $footer = $manager->read($path);
        $footer->scale(width: 60);
        $footer->toPng()->save('storage/student/' . $id . '/' . $code . '_list.png');
        // $footer->toWebp()->save('storage/student/' . $id . '/' . $code . '_list.webp');
    }
}
