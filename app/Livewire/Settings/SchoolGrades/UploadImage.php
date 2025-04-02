<?php

namespace App\Livewire\Settings\SchoolGrades;

use App\Models\Settings\SchoolGrades;
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
    public $school_gredes;
    public $photo;
    public $rules;

    public function mount($id)
    {
        if ($id) {
            $this->school_gredes = SchoolGrades::find($id);
            $this->photo = $this->school_gredes->id . '/' . $this->school_gredes->logo_path;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-grades.upload-image');
    }
    public function changePhoto()
    {
        $this->dispatch('submitForm');
    }
    public function updated($property)
    // public function uploadPhoto()
    {
        if (Storage::directoryMissing('public/schoolGrades')) {
            Storage::makeDirectory('public/schoolGrades', 0755, true, true);
        }
        if ($property === 'uploadimage') {
            $this->rules = [
                'uploadimage'   => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ];

            $this->validate();
            if (Storage::directoryMissing('public/schoolGrades/' . $this->school_gredes->id)) {
                Storage::makeDirectory('public/schoolGrades/' . $this->school_gredes->id, 0755, true, true);
            }
            Storage::deleteDirectory('public/schoolGrades/' . $this->school_gredes->id);
            if (isset($this->uploadimage)) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                $path = storage_path('app/public/schoolGrades/' . $this->school_gredes->id);

                // Verifica se o diretório existe e, se não, cria com permissão 755
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $this->uploadimage->storeAs('public/schoolGrades/' . $this->school_gredes->id, $new_name);
                $this->school_gredes->logo_path = $new_name;
                $this->school_gredes->save();

                $this->logo(
                    'schoolGrades/' . $this->school_gredes->id . '/' . $new_name,
                    $this->school_gredes->id,
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
        $this->school_gredes->logo_path = '';
        $this->school_gredes->save();
        if (Storage::directoryMissing('public/schoolGrades/' . $this->school_gredes->id)) {
            Storage::makeDirectory('public/schoolGrades/' . $this->school_gredes->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/schoolGrades/' . $this->school_gredes->id);
        $this->photo = $this->school_gredes->logo_path;
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
        $image->toPng()->save('storage/schoolGrades/' . $id . '/' . $code . '_small.png');
        // $image->toWebp()->save('storage/schoolGrades/' . $id . '/' . $code . '_small.webp');
        $image->scale(width: 200);
        $image->toPng()->save('storage/schoolGrades/' . $id . '/' . $code . '_big.png');
        // $image->toWebp()->save('storage/schoolGrades/' . $id . '/' . $code . '_big.webp');
        $image->scale(width: 300);
        // List
        $footer = $manager->read($path);
        $footer->scale(width: 60);
        $footer->toPng()->save('storage/schoolGrades/' . $id . '/' . $code . '_list.png');
        // $footer->toWebp()->save('storage/schoolGrades/' . $id . '/' . $code . '_list.webp');
    }
}
