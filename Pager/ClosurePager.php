<?php

namespace SmilingPlants\PagerBundle\Pager;

/**
 * 
 *
 * @author Magnus Nordlander
 */
class ClosurePager implements PagerInterface
{
  private $count_callable;
  private $fragment_callable;
  private $per_page;
  private $count;
  
  private $current_page = null;
  private $data = null;
  
  /**
  * 
  *
  * @author Magnus Nordlander
  */
  public function __construct($count_callable, $fragment_callable, $per_page)
  {
    if (!is_callable($count_callable))
    {
      throw new \InvalidArgumentException('First argument must be a callable.');
    }
    if (!is_callable($fragment_callable))
    {
      throw new \InvalidArgumentException('Second argument must be a callable.');
    }
    
    $this->count_callable = $count_callable;
    $this->fragment_callable = $fragment_callable;
    $this->per_page = $per_page;
    
    $this->count = call_user_func($count_callable);
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function setCurrentPage($page, $fail_gracefully = false)
  {
    if ($page > ($max_page = $this->getLastPage()) && $page > 1)
    {
      if ($fail_gracefully)
      {
        $page = $max_page;
      }
      else
      {
        throw new \InvalidArgumentException(sprintf("Page %d doesn't exist, last page is %d", $page, $max_page));
      }
    }

    $this->current_page = $page;
    
    $location = $this->getFirstIndice();
    $length = $this->per_page;
    
    $callable = $this->fragment_callable;
    $this->data = call_user_func($callable, $location, $length);

    if (!($this->data instanceof \Traversable) && !is_array($this->data))
    {
      throw new \InvalidArgumentException("Fragment callback must return instance of Traversble, or an array.");
    }
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getData()
  {
    if (($this->data instanceof \Traversable) || is_array($this->data))
    {
      return $this->data;
    }
    
    throw new \LogicException("getData cannot be called before setCurrentPage has been called.");
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function count()
  {
    return $this->count;
  }

  /**
   * @author Magnus Nordlander
   **/
  public function getFirstIndice()
  {
    return ($this->getCurrentPage()-1)*$this->per_page;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getFirstPage()
  {
    return 1;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getLastIndice()
  {
    $first_indice = $this->getFirstIndice();
    if (($nominal_last_indice = $first_indice+($this->per_page-1)) > $this->count())
    {
      return $this->count() - 1;
    }
    return $nominal_last_indice;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getLastPage()
  {
    return ceil($this->count/$this->per_page);
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getMaxPerPage()
  {
    return $this->per_page;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function isFirstPage()
  {
    return $this->getCurrentPage() == $this->getFirstPage();
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function isLastPage()
  {
    return $this->getCurrentPage() == $this->getLastPage();
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function haveToPaginate()
  {
    return $this->count() > $this->per_page;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getNextPage()
  {
    return $this->isLastPage() ? null : $this->getCurrentPage() + 1;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getPreviousPage()
  {
    return $this->isFirstPage() ? null : $this->getCurrentPage() - 1;
  }
  
  /**
   * @author Magnus Nordlander
   **/
  public function getCurrentPage()
  {
    return $this->current_page;
  }
}
