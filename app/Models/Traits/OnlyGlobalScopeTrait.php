<?php

namespace App\Models\Traits;

trait OnlyGlobalScopeTrait
{
    public static function onlyGlobalScope(): bool
    {
        /**
         * Legenda:
         * true:  Isso diz que essa model (a resource identifica isso) só permite ser acessada se estiver FORA do contexto de tenant
         * false: Pode ser acessada com ou sem contexto de tenant (padrão)
         */
        return true;
    }
}
