<?php


namespace App\Enums;

enum SignatureRole: string
{
    case Diretor = 'diretor';
    case ViceDiretor = 'vice_diretor';
    case Secretario = 'secretario';
    case AuxiliarSecretario = 'vice_secretario';
    case ComandanteCia = 'comandante_cia';
    case Sargenteante = 'sargenteante';
    // case Tesoureiro = 'tesoureiro';
    // case Financeiro = 'financeiro';
    // case Outros = 'outros';

    public function dbName(): string
    {
        return match ($this) {
            self::Diretor => 'diretor',
            self::ViceDiretor => 'vice_diretor',
            self::Secretario => 'secretario',
            self::AuxiliarSecretario => 'vice_secretario',
            self::ComandanteCia => 'comandante_cia',
            self::Sargenteante => 'sargenteante',
            // self::Tesoureiro => 'tesoureiro',
            // self::Financeiro => 'financeiro',
            // self::Outros => 'outros',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Diretor => 'Diretor/a',
            self::ViceDiretor => 'Vice-diretor/a',
            self::Secretario => 'Secretário/a',
            self::AuxiliarSecretario => 'Auxiliar do/a secretário/a',
            self::ComandanteCia => 'Comandante de Companhia',
            self::Sargenteante => 'Sargenteante',
            // self::Tesoureiro => 'Tesoureiro',
            // self::Financeiro => 'Financeiro',
            // self::Outros => 'Outros',
        };
    }
    public function nick(): string
    {
        return match ($this) {
            self::Diretor => 'CMT',
            self::ViceDiretor => 'SUB CMT',
            self::Secretario => 'CA',
            self::AuxiliarSecretario => 'AUX CA',
            self::ComandanteCia => 'CMT CIA',
            self::Sargenteante => 'SGTE',
            // self::Tesoureiro => 'Tesoureiro',
            // self::Financeiro => 'Financeiro',
            // self::Outros => 'Outros',
        };
    }
    public function msg(): string
    {
        return match ($this) {
            self::Diretor => 'Já existe um/a diretor/a ativo/a',
            self::ViceDiretor => 'Já existe um/a vice-diretor/a ativo/a',
            self::Secretario => 'Já existe um/a secretário/a ativo/a',
            self::AuxiliarSecretario => 'Já existe um/a auxiliar do/a secretário/a ativo/a',
            self::ComandanteCia => 'Já existe um comandante de companhia ativo',
            self::Sargenteante => 'Já existe um sargenteante ativo',
            // self::Tesoureiro => 'Tesoureiro',
            // self::Financeiro => 'Financeiro',
            // self::Outros => 'Outros',
        };
    }

    /**
     * Cor para badges.
     */
    public function badge(): string
    {
        return match ($this) {
            self::Diretor => 'error',
            self::ViceDiretor => 'warning',
            self::Secretario => 'info',
            self::AuxiliarSecretario => 'success',
            self::ComandanteCia => 'success',
            self::Sargenteante => 'success',
        };
    }

    /**
     * Ícone (Heroicons).
     */
    public function icon(): string
    {
        return match ($this) {
            self::Diretor => 'shield-check',
            self::ViceDiretor => 'shield-exclamation',
            self::Secretario => 'document-text',
            self::AuxiliarSecretario => 'clipboard-document',
            self::ComandanteCia => 'clipboard-document',
            self::Sargenteante => 'clipboard-document',
        };
    }

    /**
     * Retorna todas as opções para selects.
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $role) => [
                $role->value => $role->label(),
            ])
            ->toArray();
    }

    /**
     * Retorna a instância do enum a partir do valor do banco de dados.
     */
    public static function fromDb(string $dbValue): ?self
    {
        return self::tryFrom($dbValue);
    }
}
