<?php


namespace AppBundle\Helper;


use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginatedResourceFactory
{
    /**
     * @param Paginator $paginator
     * @param $page
     *
     * @return PaginatedResource
     */
    public static function fromPaginator(Paginator $paginator, $page)
    {
        return self::create(
            iterator_to_array($paginator),
            $page,
            $paginator->getQuery()->getMaxResults(),
            $paginator->count()
        );
    }

    /**
     * @param array $data
     * @param $page
     * @param $perPage
     * @param $count
     *
     * @return PaginatedResource
     */
    public static function create(array $data, $page, $perPage, $count)
    {
        $resource = new PaginatedResource();
        $resource->setData($data);

        if ($perPage > 0) {
            $totalPages = ceil($count / $perPage);
        } else {
            $totalPages = 0;
        }

        $resource->setPage($page);
        $resource->setTotalElements($count);
        $resource->setTotalPages($totalPages);

        if ($totalPages != 0 && $page >= $totalPages || $page < 0) {
            throw new NotFoundHttpException('Page does not exist.');
        }

        return $resource;
    }
}