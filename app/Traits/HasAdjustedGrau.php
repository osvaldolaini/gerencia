<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait HasAdjustedGrau
{
    public function getAdjustedGrauAttribute()
    {
        return $this->calculateAdjustedGrau();
    }

    protected function calculateAdjustedGrau()
    {
        $nota = number_format(floatval($this->grau), 2);
        $punicoes = $this->fafd()->whereNotNull('bi_date')->orderBy('bi_date')->get();
        $dataReferencia = null;

        Log::debug("Nota inicial: {$nota}");

        if ($punicoes->isEmpty()) {
            if ($this->entry_date) {
                $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
                if (now()->gt($dataReferencia)) {
                    $dias = $dataReferencia->diffInDays(now());
                    $incremento = number_format($dias * 0.01, 2);
                    $nota += $incremento;
                    $nota = number_format(min($nota, 10.00), 2);
                    Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
            }
            return $nota;
        }

        foreach ($punicoes as $p) {
            $dataP = Carbon::parse($p->bi_date);
            $grauPunicao = number_format(floatval($p->grau), 2);

            $nota -= $grauPunicao;
            $nota = number_format(max($nota, 0.00), 2);

            Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

            $dataReferencia = $dataP->copy()->addDays(180);
            Log::debug("Nova data de referência após punição (90+90 dias): {$dataReferencia->format('Y-m-d')}");
        }

        if ($dataReferencia && now()->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays(now());
            $incremento = number_format($dias * 0.01, 2);
            $nota += $incremento;
            $nota = number_format(min($nota, 10.00), 2);

            Log::debug("Ajuste final após 180 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            Log::debug("Ainda não passaram 180 dias desde a última punição.");
        }

        return $nota;
    }
}
