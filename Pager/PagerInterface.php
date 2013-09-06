<?php

namespace SmilingPlants\PagerBundle\Pager;

/**
 * @author Jon Gotlin
 */
interface PagerInterface
{
    public function setCurrentPage($page, $fail_gracefully = false);

    public function getData();

    public function count();

    public function getFirstIndice();

    public function getFirstPage();

    public function getLastIndice();

    public function getLastPage();

    public function getMaxPerPage();

    public function isFirstPage();

    public function isLastPage();

    public function haveToPaginate();

    public function getNextPage();

    public function getPreviousPage();

    public function getCurrentPage();
}
