<?php

namespace AppBundle\Helper;

use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;

class FilterHelper
{
    public static function apply(QueryBuilder $qb, array $parameters)
    {
        foreach ($parameters as $field => $value) {
            $field = Camelizer::camelize($field);

            if (is_bool($value)) {
                self::booleanExpr($qb, $field, $value);
            } elseif (is_array($value)) {
                self::operatorExpr($qb, $field, $value);
            } else {
                self::likeExpr($qb, $field, $value);
            }
        }

        return $qb;
    }

    private static function likeExpr(QueryBuilder $qb, $field, $value)
    {
        $qb->orWhere($qb->expr()->like(
            sprintf('LOWER(a.%s)', $field), $qb->expr()->literal($value)
        ));
    }

    private static function operatorExpr(QueryBuilder $qb, $field, $value)
    {
        $qb->andWhere(
            new Comparison(sprintf('a.%s', $field), $value['operator'], $qb->expr()->literal($value['value']))
        );
    }

    private static function booleanExpr(QueryBuilder $qb, $field, $value)
    {
        $qb->andWhere(
            $qb->expr()->eq(sprintf('a.%s', $field), $qb->expr()->literal($value))
        );
    }
}
