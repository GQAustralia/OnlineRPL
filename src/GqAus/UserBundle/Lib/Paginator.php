<?php
// GqAus/UserBundle/Lib/Paginator.php
 
namespace GqAus\UserBundle\Lib;
 
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
 
class Paginator
{
    private $count;
    private $currentPage;
    private $totalPages;
 
    /**
    * paginate results
    *
    * @param $query - naming is a bit off as it can be a NativeQuery OR QueryBuilder, we'll survive eventually
    * @param int $page
    * @param $limit
    * @return array
    */
    public function paginate($query, $page = 1, $limit)
    {
        // setting current page
        $this->currentPage = $page;
        // set the limit
        $limit = (int)$limit;
 
        // set limit and offset, getting the query out of queryBuilder
        $query = $query->setFirstResult(($page -1) * $limit)->setMaxResults($limit)->getQuery();

        // using already build Doctrine paginator to get a count
        // for all records. Saves load.
        $paginator = new DoctrinePaginator($query, $fetchJoinCollection = true);
        $this->count = count($paginator);
        
        // set total pages
        $this->totalPages = ceil($this->count / $limit);
 
        return $query->getResult();
    }
 
    /**
    * get current page
    *
    * @return int
    */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
 
    /**
    * get total pages
    *
    * @return int
    */
    public function getTotalPages()
   {
       return $this->totalPages;
   }
 
   /**
   * get total result count
   *
   * @return int
   */
   public function getCount()
   {
   return $this->count;
   }
} ?>