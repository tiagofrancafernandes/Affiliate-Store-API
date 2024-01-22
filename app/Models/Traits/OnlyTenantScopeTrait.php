<?php

namespace App\Models\Traits;

trait OnlyTenantScopeTrait
{
    public static function onlyTenantScope(): bool
    {
        /**
         * Legenda:
         * true:  Isso diz que essa model (a resource identifica isso) só permite ser acessada se estiver DENTRO de contexto de tenant
         * false: Pode ser acessada com ou sem contexto de tenant (padrão)
         */
        return true;
    }
}
