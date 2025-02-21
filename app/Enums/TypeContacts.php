<?php

namespace App\Enums;

enum TypeContacts: string
{
        // case SuperAdmin = 'super_admin';
    case Email = 'email';
    case Fixo = 'fixo';
    case Móvel = 'movel';
    case Whatssapp = 'whatsapp';
    case Telegram = 'telegram';

    public function badgeClass(): string
    {
        return match ($this) {
            // self::SuperAdmin => 'badge-danger',
            self::Email => 'badge-success',
            self::Fixo => 'badge-warning',
            self::Móvel => 'badge-warning',
            self::Whatssapp => 'badge-warning',
            self::Telegram => 'badge-warning',
        };
    }
    public function dbName(): string
    {
        return match ($this) {
            self::Email => 'email',
            self::Fixo => 'fixo',
            self::Móvel => 'movel',
            self::Whatssapp => 'whatsapp',
            self::Telegram => 'telegram',
        };
    }
    public function role(): string
    {
        return match ($this) {
            self::Email => 'email',
            self::Fixo => 'text',
            self::Móvel => 'text',
            self::Whatssapp => 'text',
            self::Telegram => 'text',
        };
    }
    public function mask(): string
    {
        return match ($this) {
            self::Email => '',
            self::Fixo => '(99) 9999-9999',
            self::Móvel => '(99) 9 9999-9999',
            self::Whatssapp => '(99) 9 9999-9999',
            self::Telegram => '(99) 9 9999-9999',
        };
    }
    public function label(): string
    {
        return match ($this) {
            self::Email => 'Email',
            self::Fixo => 'Telefone fixo',
            self::Móvel => 'Telefone celular',
            self::Whatssapp => 'Whatsapp',
            self::Telegram => 'Telegram',
        };
    }
}
