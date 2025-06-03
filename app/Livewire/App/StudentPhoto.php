<?php

namespace App\Livewire\App;

use App\Models\Peoples;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StudentPhoto extends Component
{
    use WithFileUploads;

    public $uploadimage;
    public $old_photo;
    public $foto;
    public $student;
    public $photo;

    public bool $seeOldPhoto = true;
    public bool $seePhoto = false;

    #[On('getStudent')]
    public function mount(Peoples $student)
    {
        $this->student = $student;
        $this->old_photo = $this->student->id . '/' . $this->student->logo_path;
    }

    public function render()
    {
        return view('livewire.app.student-photo');
    }

    #[On('esconderFotoAntiga')]
    public function ocultarFotoAntiga()
    {
        $this->seeOldPhoto = false;
    }

    #[On('seeOldPhoto')]
    public function seeOldPhoto()
    {
        $this->seeOldPhoto = true;
    }
    #[On('cropImage')]
    public function cropImage($image)
    {
        Log::debug('Tamanho da string da imagem: ' . strlen($image));

        $data = explode(',', $image);
        $imageData = base64_decode($data[1]);

        $directory = 'public/student/' . $this->student->id;
        $fullPath = storage_path('app/' . $directory);

        $code = Str::uuid();
        $new_name = $code . '.jpg';

        Log::debug('Caminho: ' . $fullPath);

        if ($this->student->logo_path) {
            Storage::deleteDirectory($directory);
        }

        // Apaga apenas a imagem anterior, se existir
        if (Storage::directoryMissing('public/student/' . $this->student->id)) {
            // Criar diretório com permissões forçadas
            if (!file_exists($fullPath)) {
                umask(0); // Remove restrições do sistema
                mkdir($fullPath, 0755, true);
            }
            chmod($fullPath, 0755); // Garante a permissão correta
        }


        file_put_contents($fullPath  . '/' . $new_name, $imageData);



        // Atualizar o caminho da imagem no banco
        $this->student->logo_path = $new_name;
        $this->student->save();

        // Chamar a função logo
        $this->logo(
            'student/' . $this->student->id . '/' . $new_name,
            $this->student->id,
            $code
        );

        $this->dispatch('seeOldPhoto');
        $this->seePhoto = true;

        $this->openAlert('success', 'Imagem atualizada com sucesso');
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

        $image->scale(width: 30)
            ->toPng()
            ->save($savePath . $code . '_small.png');

        // Criar imagem para a lista
        $footer = $manager->read($fullPath);
        $footer->scale(width: 60)
            ->toPng()
            ->save($savePath . $code . '_list.png');
    }
}
