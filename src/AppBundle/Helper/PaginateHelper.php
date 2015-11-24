<?php

namespace AppBundle\Helper;

use Doctrine\ORM\QueryBuilder;

class PaginateHelper
{
    const DEFAULT_PER_PAGE = 10;

    const MAX_PER_PAGE = 1000;

    public static function apply(QueryBuilder $qb, $page, $perPage)
    {
        if ($perPage > self::MAX_PER_PAGE) {
            $perPage = self::MAX_PER_PAGE;
        }

        $qb
            ->setFirstResult($page * $perPage)
            ->setMaxResults($perPage);

        return $qb;
    }
}
