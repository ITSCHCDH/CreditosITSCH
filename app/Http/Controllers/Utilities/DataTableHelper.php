<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class DataTableHelper {

    static function applyAll(Builder &$query, DataTableAttr &$dtAttr, array $except = []) {
        if (!(in_array('whereLike', $except)))
            self::whereLike($query, $dtAttr);

        if (!(in_array('sortBy', $except)))
            self::sortBy($query, $dtAttr);

        if (!(in_array('paginate', $except)))
            self::paginate($query, $dtAttr);

        if (!(in_array('paginatorResponse', $except)))
            return self::paginatorResponse($query, $dtAttr);
    }
    static function sortBy(Builder &$query, DataTableAttr &$dtAttr) {
        $query->orderBy($dtAttr->getOrderColumnName(), $dtAttr->getDir());
    }

    static function paginate(Builder &$query, DataTableAttr &$dtAttr) {
        $query = $query->paginate($dtAttr->getLength(), ['*'], 'page', $dtAttr->getPageNumber());
    }

    static function whereLike(Builder &$query, DataTableAttr &$dtAttr) {
        if (!$dtAttr->getSearchRegex() || $dtAttr->getSearchValue() == '')
            return;

        $searchValue = $dtAttr->getSearchValue();
        foreach ($dtAttr->getColumns() as $column) {
            if ($column->isSearchable()) {
                $canonicalFieldName = self::getCanonicalColumn($dtAttr->getSelectColumns(), $column->getFieldName());

                if (!is_null($canonicalFieldName))
                    $query->orWhere($canonicalFieldName, 'LIKE', "%$searchValue%");
            }
        }
    }

    static function paginatorResponse(&$paginator, DataTableAttr &$dtAttr) {
        if (!($paginator instanceof LengthAwarePaginator))
            throw new InvalidArgumentException('Invalid argument: must be of type Illuminate\\Pagination\LengthAwarePaginator');
        $data_attr = json_decode(json_encode($paginator));
        return [
            'draw' => $dtAttr->getDraw(),
            'data' => $data_attr->data,
            'recordsTotal' => $data_attr->total,
            'recordsFiltered' => $data_attr->total
        ];
    }

    static private function getCanonicalColumn($selectColumns, $alias) {
        foreach ($selectColumns as $selCol) {
            $pos = strpos($selCol, $alias);
            if ($pos !== false) {
                // Primer caso: si a columna seleccionada no tiene alias, entonces esta es la que estamos buscando
                $alias_keywork_pos = strpos($selCol, ' as ');
                if ($alias_keywork_pos === false) {
                    return $selCol;
                }

                // Caso 2: si el alias se encuentra despues del 'as' keyword, entonces esta columna es la que estamos buscando
                if ($alias_keywork_pos < $pos)
                    // Solo retornamos el campo formato tabla.columna: ejem usuarios.nombre as apodo, solo retornariamos 'usuarios.nombre'
                    return substr($selCol, 0, $alias_keywork_pos);
            }
        }
        return null;
    }
}
