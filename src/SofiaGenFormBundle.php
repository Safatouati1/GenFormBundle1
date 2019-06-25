<?php
/**
 * Created by PhpStorm.
 * User: safa
 * Date: 11/06/2019
 * Time: 12:28 PM
 */

namespace Sofia\GenFormBundle;


use Sofia\GenFormBundle\DependencyInjection\SofiaGenFormExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SofiaGenFormBundle extends Bundle
{

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new SofiaGenFormExtension();
        }
        return $this->extension;
    }
}