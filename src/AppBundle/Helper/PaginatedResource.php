<?php


namespace AppBundle\Helper;

use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * @ExclusionPolicy("none")
 */
class PaginatedResource
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var int
     */
    private $totalElements;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
    }

    /**
     * @return int
     */
    public function getTotalElements()
    {
        return $this->totalElements;
    }

    /**
     * @param int $totalElements
     */
    public function setTotalElements($totalElements)
    {
        $this->totalElements = $totalElements;
    }

}