<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;

use App\Traits\HandlesTmpUploads;

class StudentForm extends Component
{

    use HandlesTmpUploads;
    public $rules;

    public $back = 'student-list';
    public $route = 'student';

    public $breadcrumb = 'Estudante';
    //Fields
    public $id;
    public $name;
    public $nick;
    public $number;
    public $sex;
    public $grau;
    public $entry_date;
    public $english_level;
    public $student;

    public $birthday;
    public $state_birth;
    public $city_birth;
    public $mom;
    public $dad;


    public function mount(Peoples $students)
    {
        if ($students->getAttributes()) {
            $this->student           = $students;
            $this->id           = $students->id;
            $this->name         = $students->name;
            $this->nick         = $students->nick;
            $this->number       = $students->number;
            $this->sex          = $students->sex;
            $this->birthday          = $students->birthday;
            $this->state_birth          = $students->state_birth;
            $this->city_birth          = $students->city_birth;
            $this->mom          = $students->mom;
            $this->dad          = $students->dad;
            $this->grau         = number_format($students->grau, 2);
            $this->entry_date   = $students->entry_date;
            $this->english_level  = $students->english_level;
        }
        // dd($students->birth);
    }

    public function render()
    {
        return view('livewire.students.student-form');
    }

    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            // 'number' => 'max:5|required|' . Rule::unique('peoples')->ignore($this->id),
            'sex'   => 'required',
            'name'  => 'required',
            'nick'  => 'required',
            'grau'  => 'required|lte:10',
            'entry_date' => 'required'
        ];
        $this->validate();
        if ($this->id) {
            Peoples::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'nick' => $this->nick,
                'number' => $this->number,
                'sex' => $this->sex,
                'grau' => $this->grau,
                'entry_date' => $this->entry_date,
                'birthday' => $this->birthday,
                'state_birth' => $this->state_birth,
                'city_birth' => $this->city_birth,
                'dad' => $this->dad,
                'mom' => $this->mom,
                'english_level' => $this->english_level,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $students = Peoples::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'sex'       => $this->sex,
                'number'    => $this->number,
                'english_level' => $this->english_level,
                'entry_date' => $this->entry_date,
                'grau'      => $this->grau,
                'birthday' => $this->birthday,
                'state_birth' => $this->state_birth,
                'city_birth' => $this->city_birth,
                'dad' => $this->dad,
                'mom' => $this->mom,
                'type'      => 1,
                'code'      => Str::uuid(),
            ]);
            $id = $students->id;
            $msg = 'Registro criado com sucesso.';
        }

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
    //Imprimir relação
    public function printRegistration()
    {
        // dd($this->student);
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos/brasao-brasil-preto-e-branco.png');

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.students.student-registration-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Certidão de matrícula',
                'student'           => $this->student,
                'config'            => $config,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
                  <table width="100%" style="text-align:center;">
                        <tr >
                            <td width="100%">
                                <img width="50" src="' . $logoPath . '" alt="Logo">
                            </td>
                        </tr>
                        <tr >
                            <td width="100%">
                                MINISTÉRIO DA DEFESA
                            </td>
                        </tr>
                        <tr >
                            <td width="100%">
                                EXÉRCITO BRASILEIRO
                            </td>
                        </tr>
                        <tr >
                            <td width="100%">
                              ' . $config->name . '
                            </td>
                        </tr>
                        <tr >
                            <td width="100%">
                              ' . $config->nick . '
                            </td>
                        </tr>
                  </table>
                  ');
        $mpdf->SetHTMLFooter('
           <table width="100%">
               <tr>
                   <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
                   <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
               </tr>
           </table>');
        $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        $file = trim('certidao_de_matricula_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfRegistration', pdfPath: $pdfPath);
    }
}
