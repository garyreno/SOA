<?php

namespace Service\GoogleCodeBundle\Tests\Libraries;

use Symfony\Component\HttpFoundation\Request;
use \Library\ManagerBundle\Libraries\Query;
use \Library\ManagerBundle\Libraries\ResultSet;
use \Service\GoogleCodeBundle\Libraries\Manager as GoogleCodeManager; 
use \Service\GoogleCodeBundle\Libraries\UrlParamsMapper;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
 
    /**
     * @test 
     */
    public function extendsManagerAbstract()
    {
        $manager = new GoogleCodeManager(new Request());
        $this->assertInstanceOf('\Library\ManagerBundle\Abstracts\Manager', $manager);
    }
    
    /**
     * @test 
     */
    public function getSearchResultsForCorrectQuery()
    {
        $request = new Request();
        $request->initialize(array(
            'query_string' => 'query=symfony&lang=php'
        ));
        
        $manager = new GoogleCodeManager($request);
        
        $resultSet = $manager->getSearchResults();
        
        $this->assertTrue($resultSet->success);
        $this->assertGreaterThan(0, count($resultSet->results));
        $this->assertNull($resultSet->message);
    }
    
    /**
     * @test 
     */
    public function getSearchResultsForIncorrectQuery()
    {
        $request = new Request();
        $request->initialize(array(
            'query_string' => 'query=absfduyfanbcsgfsacgf&lang=phpphpphp'
        ));
        
        $manager = new GoogleCodeManager($request);
        
        $resultSet = $manager->getSearchResults();
        
        $this->assertFalse($resultSet->success);
        $this->assertCount(0, $resultSet->results);
        $this->assertNull($resultSet->message);
    }
    
    /**
     * @test 
     */
    public function getSearchResultsEmptyQuery()
    {
        $urlParamsMapper = new UrlParamsMapper();
        
        $request = new Request();
        $request->initialize(array(
            $urlParamsMapper->getQueryParamName()       => '',
            $urlParamsMapper->getLanguageParamName()    => ''
        ));
        
        $manager = new GoogleCodeManager($request);
        
        $resultSet = $manager->getSearchResults();
        
        $this->assertFalse($resultSet->success);
        $this->assertCount(0, $resultSet->results);
        $this->assertNull($resultSet->message);
    }
}
