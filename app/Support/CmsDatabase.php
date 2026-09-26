<?php

namespace App\Support;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use PDOException;

class CmsDatabase
{
    private static ?bool $available = null;

    public static function hasTable(string $table): bool
    {
        if (self::$available === false) {
            return false;
        }

        try {
            $exists = Schema::hasTable($table);
            self::$available = true;

            return $exists;
        } catch (QueryException|PDOException) {
            self::$available = false;

            return false;
        }
    }
}
