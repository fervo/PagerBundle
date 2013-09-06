<?php

namespace SmilingPlants\PagerBundle\Pager;

/**
 * @author Jon Gotlin
 */
class EmptyPager implements PagerInterface
{
    public function setCurrentPage($page, $fail_gracefully = false)
    {
    }  

    public function getData()
    {
        return [];
    }
    
    public function count()
    {
        return 0;
    }

    public function getFirstIndice()
    {
        return 0;
    }
    
    public function getFirstPage()
    {
        return 1;
    }
    
    public function getLastIndice()
    {
        return 0;
    }
    
    public function getLastPage()
    {
        return 1;
    }
    
    public function getMaxPerPage()
    {
        return 0;
    }
    
    public function isFirstPage()
    {
        return true;
    }
    
    public function isLastPage()
    {
        return true;
    }
    
    public function haveToPaginate()
    {
        return false;
    }
    
    public function getNextPage()
    {
        return null;
    }
    
    public function getPreviousPage()
    {
        return null;
    }
    
    public function getCurrentPage()
    {
        return 1;
    }
}