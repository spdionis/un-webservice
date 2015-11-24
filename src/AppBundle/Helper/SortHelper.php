<?php

namespace AppBundle\Helper;

use Doctrine\ORM\QueryBuilder;

class SortHelper
{
    public static function apply(QueryBuilder $qb, array $orderBy)
    {
        foreach ($orderBy as $field => $sortOrder) {
            $qb->orderBy('a.' . Camelizer::camelize($field), $sortOrder);
        }

        return $qb;
    }
}
