<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CompanySignature extends Component

{
    use WithFileUploads;

    public $uploadimage;
    public $companies;
    public $signature;
    public $rules;

    public function mount($id)
    {
        if ($id) {
            $this->companies = Companies::find($id);
            $files = Storage::files('public/companies/' . $this->companies->id . '/signature');
            if ($files) {
                $signature = explode('/', $files[0]);
                // dd($signature[4]);
                $this->signature = url('storage/companies/' . $this->companies->id . '/signature/' . $signature[5]); // Nome do arquivo
            } else {
                $this->signature = '';
            }
        }
    }
    public function render()
    {
        return view('livewire.settings.companies.company-signature');
    }
    public function changeSignature()
    {
        $this->dispatch('submitForm');
    }
    public function updated($property)
    // public function uploadsignature()
    {
        if ($property === 'uploadimage') {
            $this->rules = [
                'uploadimage'   => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ];

            $this->validate();
            if (Storage::directoryMissing('public/companies/' . $this->companies->id . '/signature')) {
                Storage::makeDirectory('public/companies/' . $this->companies->id . '/signature', 0755, true, true);
                Storage::makeDirectory('public/companies/' . $this->companies->id . '/signature/small', 0755, true, true);
            }
            Storage::deleteDirectory('public/companies/' . $this->companies->id . '/signature');

            if (isset($this->uploadimage)) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.png';

                $path = storage_path('app/public/companies/' . $this->companies->id . '/signature');

                // Verifica se o diretório existe e, se não, cria com permissão 755
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $this->uploadimage->storeAs('public/companies/' . $this->companies->id . '/signature', $new_name);
                $this->logo(
                    'companies/' . $this->companies->id . '/signature/',
                    $this->companies->id,
                    $new_name
                );
            }
        }
    }
    public function excluirTemp()
    {
        $this->uploadimage = '';
    }
    public function excluirSignature()
    {
        if (Storage::directoryMissing('public/companies/' . $this->companies->id . '/signature')) {
            Storage::makeDirectory('public/companies/' . $this->companies->id . '/signature', 0755, true, true);
        }
        Storage::deleteDirectory('public/companies/' . $this->companies->id . '/signature');
        $this->signature = '';
    }
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    public static function logo($path, $id, $code)
    {
        if (Storage::directoryMissing('public/companies/' . $id . '/signature/small')) {
            Storage::makeDirectory('public/companies/' . $id . '/signature/small', 0755, true, true);
        }

        // $files = Storage::files('public/companies/' . $id . '/signature');
        // if ($files) {
        //     $signature = explode('/', $files[0]);
        // }

        $new_path = 'storage/' . $path . $code;
        // dd($path);
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($new_path);
        // dd($image, $path . 'small/' . $code);
        $image->scale(width: 120);
        $image->toPng()->save('storage/' . $path . 'small/' . $code);
    }
}
