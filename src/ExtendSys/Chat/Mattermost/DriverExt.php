<?php

namespace App\ExtendSys\Chat\Mattermost;

use Gnello\Mattermost\Driver;
use Pimple\Container;

/**
 * Class Driver Ext
 * 
 * For custom Call 
 */
class DriverExt extends Driver
{
    /**
     * Driver constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * For call -> getModel method parent
     * 
     * @param $className
     * @return mixed
     */
    private function getModelExt($className)
    {
        $reflectionMethod = new \ReflectionMethod('ExtendSys\Chat\Mattermost\DriverExt', 'getModel');
        $reflectionMethod->setAccessible(true);

        $classInt = $reflectionMethod->invoke($this, $className);
        
        return $classInt;
    }

    /**
     * Example for Class UserModelExt
     * 
     * @return UserModelExt
     */
    public function getUserModelExt()
    {
        return $this->getModelExt(UserModelExt::class);
    }
}