<?php

namespace SmilingPlants\PagerBundle\Twig\Extension;

use SmilingPlants\PagerBundle\Pager\ClosurePager;

class SmilingPlantsPagerExtension extends \Twig_Extension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return array('jumpingwindow' => new \Twig_Function_Method($this, 'getJumpingWindow'),
                     'slidingwindow' => new \Twig_Function_Method($this, 'getSlidingWindow'));
    }
    
    /**
     * @author Magnus Nordlander
     **/
    public function getJumpingWindow(ClosurePager $pager, $window_size)
    {
      $window_num = ceil($pager->getCurrentPage()/$window_size);
      $window_low = (($window_num-1)*$window_size)+1;
      $nominal_window_high = $window_low+$window_size-1;
      if (($last_page = $pager->getLastPage()) < $nominal_window_high)
      {
        return range($window_low, $last_page);
      }
      
      return range($window_low, $nominal_window_high);
    }
    
    /**
     * @author Magnus Nordlander
     **/
    public function getSlidingWindow(ClosurePager $pager, $window_size)
    {
      $pivot = $pager->getCurrentPage();
      $last_page = $pager->getLastPage();

      if ($window_size > $last_page) 
      {
          $window_size = $last_page;
      }

      $window_low = $pivot-(floor($window_size/2));
      $window_high = $pivot+(ceil($window_size/2)-1);

      if ($window_low < 1) 
      {
          $window_high = $window_high-$window_low+1;
          $window_low = 1;
      }

      if ($window_high > $last_page) 
      {
          $window_low = $window_low-$window_high+$last_page;
          $window_high = $last_page;
      }

      return range($window_low, $window_high);
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'smilingplantspager';
    }
}
