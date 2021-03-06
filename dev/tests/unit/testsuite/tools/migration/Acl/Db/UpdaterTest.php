<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Tools
 * @package     unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once realpath(dirname(__FILE__) . '/../../../../../../../') . '/tools/migration/Acl/Db/Updater.php';

class Tools_Migration_Acl_Db_UpdaterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_readerMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_writerMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_loggerMock;

    /**
     * @var array
     */
    protected $_map = array();

    public function setUp()
    {
        $this->_readerMock = $this->getMock('Tools_Migration_Acl_Db_Reader', array(), array(), '', false);
        $this->_readerMock->expects($this->once())->method('fetchAll')->will($this->returnValue(array(
            'oldResource1' => 1,
            'oldResource2' => 2,
            'Test::newResource3'  => 3,
            'additionalResource'  => 4,
        )));

        $this->_map = array(
            "oldResource1"  => "Test::newResource1",
            "oldResource2"  => "Test::newResource2",
            "oldResource3"  => "Test::newResource3",
            "oldResource4"  => "Test::newResource4",
            "oldResource5"  => "Test::newResource5"
        );

        $this->_writerMock = $this->getMock('Tools_Migration_Acl_Db_Writer', array(), array(), '', false);
        $this->_loggerMock = $this->getMockForAbstractClass(
            'Tools_Migration_Acl_Db_LoggerAbstract', array(), '', false, false, false, array('add')
        );
    }

    public function testMigrateInPreviewModeDoesntWriteToDb()
    {
        $model = new Tools_Migration_Acl_Db_Updater(
            $this->_readerMock, $this->_writerMock, $this->_loggerMock, null
        );

        $this->_writerMock->expects($this->never())->method('update');

        $this->_loggerMock->expects($this->at(0))->method('add')->with('oldResource1', 'Test::newResource1', 1);
        $this->_loggerMock->expects($this->at(1))->method('add')->with('oldResource2', 'Test::newResource2', 2);
        $this->_loggerMock->expects($this->at(2))->method('add')->with(null, 'Test::newResource3', 3);
        $this->_loggerMock->expects($this->at(3))->method('add')->with('additionalResource', null, 4);

        $model->migrate($this->_map);
    }

    public function testMigrateInRealModeWritesToDb()
    {
        $model = new Tools_Migration_Acl_Db_Updater(
            $this->_readerMock, $this->_writerMock, $this->_loggerMock, Tools_Migration_Acl_Db_Updater::WRITE_MODE
        );

        $this->_writerMock->expects($this->at(0))->method('update')->with('oldResource1', 'Test::newResource1');
        $this->_writerMock->expects($this->at(1))->method('update')->with('oldResource2', 'Test::newResource2');

        $this->_loggerMock->expects($this->at(0))->method('add')->with('oldResource1', 'Test::newResource1', 1);
        $this->_loggerMock->expects($this->at(1))->method('add')->with('oldResource2', 'Test::newResource2', 2);
        $this->_loggerMock->expects($this->at(2))->method('add')->with(null, 'Test::newResource3', 3);
        $this->_loggerMock->expects($this->at(3))->method('add')->with('additionalResource', null, 4);

        $model->migrate($this->_map);
    }
}

