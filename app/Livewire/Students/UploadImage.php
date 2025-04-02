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
    {
        if ($property === 'uploadimage') {
            $this->validate([
                'uploadimage' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]);

            $directory = 'public/student/' . $this->student->id;
            $fullPath = storage_path('app/' . $directory);

            // Apaga apenas a imagem anterior, se existir
            if ($this->student->logo_path) {
                Storage::delete($directory . '/' . $this->student->logo_path);
            }

            if ($this->uploadimage) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                // Criar diretório com permissões forçadas
                if (!file_exists($fullPath)) {
                    umask(0); // Remove restrições do sistema
                    mkdir($fullPath, 0755, true);
                }
                chmod($fullPath, 0755); // Garante a permissão correta

                // Salvar a nova imagem
                $this->uploadimage->storeAs($directory, $new_name);

                // Atualizar o caminho da imagem no banco
                $this->student->logo_path = $new_name;
                $this->student->save();

                // Chamar a função logo
                $this->logo(
                    'student/' . $this->student->id . '/' . $new_name,
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
        // Corrige o caminho do arquivo original
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            throw new \Exception("Imagem não encontrada: " . $fullPath);
        }

        // Criar o gerenciador de imagem
        $manager = new ImageManager(new Driver());

        // Carregar a imagem
        $image = $manager->read($fullPath);

        // Caminho de destino
        $savePath = storage_path('app/public/student/' . $id . '/');

        // Criar diretório se não existir
        if (!file_exists($savePath)) {
            umask(0022); // Garante permissões adequadas
            mkdir($savePath, 0755, true);
            chmod($savePath, 0755); // Ajusta a permissão corretamente
        }

        // Criar versões redimensionadas da imagem
        $image->scale(width: 200)
            ->toPng()
            ->save($savePath . $code . '_big.png');

        $image->scale(width: 300)
            ->toPng()
            ->save($savePath . $code . '_small.png');

        // Criar imagem para a lista
        $footer = $manager->read($fullPath);
        $footer->scale(width: 60)
            ->toPng()
            ->save($savePath . $code . '_list.png');
    }
}
