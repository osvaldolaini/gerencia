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
    public function getGrauStatusAttribute()
    {
        return $this->getGrauStatus($this->adjusted_grau);
    }
    public function getGrauStatusColorAttribute()
    {
        return $this->getGrauStatusColor($this->adjusted_grau);
    }

    function getGrauStatus($grau)
    {
        $grau = floatval($grau);

        if ($grau === 10.0) {
            return 'EXCEPCIONAL';
        } elseif ($grau >= 9.0) {
            return 'ÓTIMO';
        } elseif ($grau >= 6.0) {
            return 'BOM';
        } elseif ($grau >= 5.0) {
            return 'REGULAR';
        } elseif ($grau >= 3.0) {
            return 'INSUFICIENTE';
        } else {
            return 'MAU';
        }
    }
    function getGrauStatusColor($nota)
    {
        $nota = floatval($nota);

        if ($nota === 10.0) {
            return 'accent';
        } elseif ($nota >= 9.0) {
            return 'success';
        } elseif ($nota >= 6.0) {
            return 'info';
        } elseif ($nota >= 5.0) {
            return 'warning';
        } elseif ($nota >= 3.0) {
            return 'error';
        } else {
            return 'error';
        }
    }



    // protected function calculateAdjustedGrau()
    // {
    //     $nota = number_format(floatval($this->grau), 2);
    //     $punicoes = $this->fafd()->whereNotNull('bi_date')->orderBy('bi_date')->get();
    //     $dataReferencia = null;

    //     Log::debug("Nota inicial: {$nota}");

    //     if ($punicoes->isEmpty()) {
    //         if ($this->entry_date) {
    //             $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
    //             if (now()->gt($dataReferencia)) {
    //                 $dias = $dataReferencia->diffInDays(now());
    //                 $incremento = number_format($dias * 0.01, 2);
    //                 $nota += $incremento;
    //                 $nota = number_format(min($nota, 10.00), 2);
    //                 Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
    //             } else {
    //                 Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
    //             }
    //         }
    //         return $nota;
    //     }

    //     foreach ($punicoes as $p) {
    //         $dataP = Carbon::parse($p->bi_date);
    //         $grauPunicao = number_format(floatval($p->grau), 2);

    //         $nota -= $grauPunicao;
    //         $nota = number_format(max($nota, 0.00), 2);

    //         Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

    //         $dataReferencia = $dataP->copy()->addDays(180);
    //         Log::debug("Nova data de referência após punição (90+90 dias): {$dataReferencia->format('Y-m-d')}");
    //     }

    //     if ($dataReferencia && now()->gt($dataReferencia)) {
    //         $dias = $dataReferencia->diffInDays(now());
    //         $incremento = number_format($dias * 0.01, 2);
    //         $nota += $incremento;
    //         $nota = number_format(min($nota, 10.00), 2);

    //         Log::debug("Ajuste final após 180 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
    //     } else {
    //         Log::debug("Ainda não passaram 180 dias desde a última punição.");
    //     }

    //     return $nota;
    // }
    protected function calculateAdjustedGrau()
    {
        $nota = floatval($this->grau);
        $punicoes = $this->fafd()->whereNotNull('bi_date')->orderBy('bi_date')->get();
        $dataReferencia = null;

        Log::debug("Nota inicial: {$nota}");

        if ($punicoes->isEmpty()) {
            if ($this->entry_date) {
                $dataReferencia = Carbon::parse($this->entry_date)->addDays(90);
                if (now()->gt($dataReferencia)) {
                    $dias = $dataReferencia->diffInDays(now());
                    $incremento = $dias * 0.01;
                    $nota += $incremento;
                    $nota = min($nota, 10.00);
                    Log::debug("Sem punições. Dias após 90 da matrícula: {$dias}. Aumento: {$incremento}. Nota final: {$nota}");
                } else {
                    Log::debug("Sem punições. Ainda não passaram 90 dias desde a matrícula.");
                }
            }
            return number_format($nota, 2);
        }

        // ✅ Ajuste adicional ANTES da primeira punição
        $primeiraPunição = Carbon::parse($punicoes->first()->bi_date);
        if ($this->entry_date) {
            $dataEntradaMais90 = Carbon::parse($this->entry_date)->addDays(90);

            if ($primeiraPunição->gt($dataEntradaMais90)) {
                $dias = $dataEntradaMais90->diffInDays($primeiraPunição);
                $incremento = $dias * 0.01;
                $nota += $incremento;
                $nota = min($nota, 10.00);
                Log::debug("Antes da 1ª punição. Dias entre 90 dias após matrícula e 1ª punição: {$dias}. Aumento: {$incremento}. Nota atual: {$nota}");
            } else {
                Log::debug("Não houve tempo entre os 90 dias da matrícula e a 1ª punição para acréscimo.");
            }
        }

        // Aplica punições
        foreach ($punicoes as $p) {
            $dataP = Carbon::parse($p->bi_date);
            $grauPunicao = floatval($p->grau);

            $nota -= $grauPunicao;
            $nota = max($nota, 0.00);

            Log::debug("Punição em {$p->bi_date}: -{$grauPunicao}. Nota atual: {$nota}");

            // Atualiza data referência para o último castigo
            $dataReferencia = $dataP->copy()->addDays(180);
            Log::debug("Nova data de referência após punição (90+90 dias): {$dataReferencia->format('Y-m-d')}");
        }

        // Ajuste final se já passaram 180 dias da última punição
        if ($dataReferencia && now()->gt($dataReferencia)) {
            $dias = $dataReferencia->diffInDays(now());
            $incremento = $dias * 0.01;
            $nota += $incremento;
            $nota = min($nota, 10.00);

            Log::debug("Ajuste final após 180 dias da última punição: +{$incremento} ({$dias} dias). Nota final: {$nota}");
        } else {
            Log::debug("Ainda não passaram 180 dias desde a última punição.");
        }

        return number_format($nota, 2);
    }
}
