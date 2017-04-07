<?php

namespace SprykerTest\Zed\Sales\Presentation\Helper;

use Application\Module\Zed;
use Codeception\Module;
use Codeception\TestCase;

class PresentationHelper extends Module
{

    /**
     * @param \Codeception\TestCase $e
     *
     * @return void
     */
    public function _before(TestCase $e)
    {
        $this->getZedModule()->amZed();
        $this->getZedModule()->amLoggedInUser();
    }

    /**
     * @return \Application\Module\Zed
     */
    protected function getZedModule()
    {
        return $this->getModule('\\' . Zed::class);
    }

}