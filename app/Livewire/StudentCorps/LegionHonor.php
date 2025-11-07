<?php

namespace App\Livewire\StudentCorps;

use Livewire\Component;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Peoples;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;
use App\Models\StudentCorps\LegionOfHonor;
use App\Traits\HandlesTmpUploads;

class LegionHonor extends Component
{

    use WithPagination;
    use HandlesTmpUploads;
    public $breadcrumb = 'Legião de Honra';
    public $modal = true;
    public $showModal = false;
    public $showModalDelete = false;
    public $showModalRemove = false;

    public $rules;
    public $detail;
    public $peoples;
    public $legionary;
    public $sex;

    public $students = array();
    public $student;

    public $showModalConfirm = false;
    public $loading = false;


    public $id;
    public $student_id;
    public $off_bi_text;
    public $off_bi_number;
    public $off_supplement_number;
    public $off_bi_date;

    #[On('closeLegionary')]
    public function render()
    {
        $dataTable = LegionOfHonor::where('active', '!=', 0)->get();
        // Cria uma Collection estruturada
        $list = $dataTable->map(function ($item) {
            return [
                'grade'     => $item->student->al_class?->classGrade->name ?? 'Sem série',
                'year'      => $item->year,
                'student'  => $item->student,
                'color'     => ($item->student->adjusted_grau > 9.5 ? 'badge-success' : 'badge-error'),
                'grau'      => number_format($item->student->adjusted_grau,  2, ','),
                'local'     => $item->local,
                'id'        => $item->id,
                'active'        => $item->active,
                'bi_date' => $item->b_date,
                'bi_number' => $item->bi_number,
                'supplement_number' => $item->supplement_number,
                'off_bi_date' => $item->off_b_date,
                'off_bi_number' => $item->off_bi_number,
                'off_supplement_number' => $item->off_supplement_number,
            ];
        });

        // Ordena primeiro por grade, depois por ano e nome
        $this->students = json_decode(json_encode($list->sortBy([
            ['grade', 'asc'],
            ['year', 'asc'],
            ['name', 'asc'],
        ])));

        return view('livewire.student-corps.legion-honor');
    }

    public function showModalDel(LegionOfHonor $legionary)
    {
        $this->legionary             = $legionary;
        $this->showModalDelete       = true;
    }

    public function showModalRem(LegionOfHonor $legionary)
    {
        $this->legionary             = $legionary;

        $this->off_bi_text           = $legionary->off_bi_text;
        $this->off_bi_number         = $legionary->off_bi_number;
        $this->off_supplement_number = $legionary->off_supplement_number;
        $this->off_bi_date           = $legionary->off_bi_date;
        $this->showModalRemove       = true;
    }

    public function removeStudents()
    {
        $this->rules = [
            'off_bi_date'            => 'required',
            'off_bi_number'          => 'required',
            'off_supplement_number'  => 'required',
        ];

        $this->validate();

        LegionOfHonor::updateOrCreate([
            'id'    => $this->legionary->id,
        ], [
            'active'                    => 2,
            'off_bi_date'               => $this->off_bi_date,
            'off_bi_text'               => $this->off_bi_text,
            'off_supplement_number'     => $this->off_supplement_number,
            'off_bi_number'             => $this->off_bi_number,
        ]);

        $this->off_bi_text           = '';
        $this->off_bi_number         = '';
        $this->off_supplement_number = '';
        $this->off_bi_date           = '';
        $this->dispatch('openAlert', 'success', 'Cadastro excluído com sucesso');
        $this->showModalRemove = false;
    }
    public function delStudents()
    {
        $this->legionary->active = 0;
        $this->legionary->save();
        $this->dispatch('openAlert', 'success', 'Cadastro excluído com sucesso');
        $this->showModalDelete = false;
    }
    //Imprimir relação
    public function print()
    {
        // dd($this->students);
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');
        $legion = url('storage/logos/legiao-de-honra.png');

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
            'livewire.student-corps.legion-of-honor-pdf',
            [
                'logoPath'          => $logoPath,
                'legion'            => $legion,
                'title'             => 'Legião de honra',
                'students'          => $this->students,
                'config'            => $config,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
                  <table width="100%">
                      <tr >
                          <td width="50%">
                              <img width="50" src="' . $logoPath . '" alt="Logo">
                          </td>
                          <td width="50%" style="text-align: right;">
                              <strong>' . $config->name . '</strong><br>

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
        $file = trim('legiao_de_honra_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfLegion', pdfPath: $pdfPath);
    }
    public function showNewLegionary()
    {
        $this->dispatch('clearStudent');
        $this->legionary = '';
        $this->showModal = true;
    }
    public function showEditLegionary(LegionOfHonor $legionary)
    {
        $this->legionary = $legionary;
        $this->showModal = true;
    }


    #[On('closeLegionary')]
    public function closeNewLegionary()
    {
        $this->showModal = false;
    }

    public function showConfirm(Peoples $student, $percent)
    {
        $this->student = $student;
        if ($this->contacts->count() > 0) {
            $this->showModalConfirm = true;
        } else {
            $this->dispatch('openAlert', 'error', 'Nenhum contato cadastrado');
        }
    }


    public function slug($name)
    {
        return mb_strtolower(str_replace(" ", "_", $name));
    }
    public function downloadTmp()
    {
        $config = Settings::find(1);
        $company = $this->student?->al_class?->classGrade?->getCompany ?? false;
        $signature = false;
        if ($company) {
            $logoPath = Storage::exists('public/companies/' . $company->id)
                ? url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png')
                : url('storage/logos-school/logo-header.png');

            $files = Storage::files('public/companies/' . $company->id . '/signature/small');
            if ($files) {
                $sign = explode('/', $files[0]);
                // dd($signature[4]);
                $signature = url('storage/companies/' . $company->id . '/signature/small/' . $sign[5]); // Nome do arquivo
            } else {
                $signature = false;
            }
        } else {
            $logoPath = url('storage/logos-school/logo-header.png');
        }


        $studentImage = Storage::exists('public/student/' . $this->student->id)
            ? url('storage/student/' . $this->student->id . '/' . $this->student->code_image . '_list.png')
            : $logoPath;

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
            'livewire.settings.pdf.student-history-pdf',
            [
                'logoPath'          => $logoPath,
                'studentImage'      => $studentImage,
                'signature'         => $signature,
                'student'           => $this->student,
                'config'            => $config,
                'companies'         => $this->student->company,
                'subtext'           => 'Aluno da ' . ($this->student->company ? $this->student->company->nick : ''),
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
                <table width="100%">
                    <tr >
                        <td width="50%">
                            <img width="50" src="' . $logoPath . '" alt="Logo">
                        </td>
                        <td width="50%" style="text-align: right;">
                            <strong>' . $config->name . '</strong><br>
                            ' . ($this->student->company ? $this->student->company->name : '') . '<br>
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
        $file = trim('ficha_individual_' . $this->student->number . '_' . $this->slug($this->student->nick) . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        return $file;
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
