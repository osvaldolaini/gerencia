<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
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
    public $companies;
    public $photo;
    public $rules;

    public function mount($id)
    {
        if ($id) {
            $this->companies = Companies::find($id);
            $this->photo = $this->companies->id . '/' . $this->companies->logo_path;
        }
    }
    public function render()
    {
        return view('livewire.settings.companies.upload-image');
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
            if (Storage::directoryMissing('public/companies/' . $this->companies->id)) {
                Storage::makeDirectory('public/companies/' . $this->companies->id, 0755, true, true);
            }
            Storage::deleteDirectory('public/companies/' . $this->companies->id);
            if (isset($this->uploadimage)) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                $path = storage_path('app/public/companies/' . $this->companies->id);

                // Verifica se o diretório existe e, se não, cria com permissão 755
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $this->uploadimage->storeAs('public/companies/' . $this->companies->id, $new_name);
                $this->companies->logo_path = $new_name;
                $this->companies->save();

                $this->logo(
                    'companies/' . $this->companies->id . '/' . $new_name,
                    $this->companies->id,
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
        $this->companies->logo_path = '';
        $this->companies->save();
        if (Storage::directoryMissing('public/companies/' . $this->companies->id)) {
            Storage::makeDirectory('public/companies/' . $this->companies->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/companies/' . $this->companies->id);
        $this->photo = $this->companies->logo_path;
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
        $image->toPng()->save('storage/companies/' . $id . '/' . $code . '_small.png');
        // $image->toWebp()->save('storage/companies/' . $id . '/' . $code . '_small.webp');
        $image->scale(width: 200);
        $image->toPng()->save('storage/companies/' . $id . '/' . $code . '_big.png');
        // $image->toWebp()->save('storage/companies/' . $id . '/' . $code . '_big.webp');
        $image->scale(width: 300);
        // List
        $footer = $manager->read($path);
        $footer->scale(width: 60);
        $footer->toPng()->save('storage/companies/' . $id . '/' . $code . '_list.png');
        // $footer->toWebp()->save('storage/companies/' . $id . '/' . $code . '_list.webp');
    }
}
