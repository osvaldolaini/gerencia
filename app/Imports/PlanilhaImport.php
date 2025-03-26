<?php

namespace App\Imports;

use App\Models\Peoples;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Str;

class PlanilhaImport implements ToModel, WithHeadingRow
{
    protected $birthday;
    protected $name;
    protected $nick;
    protected $sex;
    protected $number;

    public function __construct() {}
    public function model(array $row)
    {
        if ($row['nr_do_aluno_00000'] != '*' && $row['nr_do_aluno_00000'] != '**') {
            $students = Peoples::create([
                'active'    => 1,
                'name'      => mb_strtoupper($row['nome_completo']),
                'birthday'  => $this->convertDay($row['data_nascimento_ddmmaaaa']),
                'nick'      => mb_strtoupper($row['nome_aluno']),
                'sex'       => mb_strtoupper($row['sexo_mf']),
                'number'    => $row['nr_do_aluno_00000'],
                'type'      => 1,
                'code'      => Str::uuid(),
            ]);
        }
    }

    public function convertDay($day)
    {
        if (is_numeric($day) && is_int((int) $day)) {
            return date('Y-m-d', strtotime('1900-01-01 + ' . ($day - 2) . ' days'));
        } else {
            return implode("-", array_reverse(explode("/", $day)));
        }
    }
}
