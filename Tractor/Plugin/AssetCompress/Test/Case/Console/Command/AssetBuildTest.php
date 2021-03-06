<?php

App::uses('ShellDispatcher', 'Console');
App::uses('ConsoleOutput', 'Console');
App::uses('ConsoleInput', 'Console');
App::uses('Shell', 'Console');
App::uses('AssetBuildTask', 'AssetCompress.Console/Command/Task');

class AssetBuildTest extends CakeTestCase {

	function setUp() {
		parent::setUp();

        $out = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$in = $this->getMock('ConsoleInput', array(), array(), '', false);

		$this->Task = $this->getMock('AssetBuildTask',
            array('getInput', 'stdout', 'stderr', '_stop', '_initEnvironment'),
            array($out, $out, $in)
        );

		$this->_pluginPath = App::pluginPath('AssetCompress');
		$this->testFilePath = $this->_pluginPath . 'Test/test_files/View/parse/';

		$this->testConfig = $this->_pluginPath . 'Test' . DS . 'test_files' . DS . 'config' . DS . 'config.ini';
		AssetConfig::clearAllCachedKeys();
		$this->config = AssetConfig::buildFromIniFile($this->testConfig);
		$this->Task->setConfig($this->config);
	}

	function tearDown() {
		parent::tearDown();
		unset($this->Dispatcher, $this->Task);
	}

	function testScanningSimpleFile() {
		$files = array($this->testFilePath . 'single.ctp');
		$this->Task->setFiles($files);
		$result = $this->Task->_scanFiles();

		$this->assertEqual(4, count($result));
		$this->assertEqual('addScript', $result[0][2][1]);
	}
	
	function testParsingSimpleFile() {
		$files = array($this->testFilePath . 'single.ctp');
		$this->Task->setFiles($files);
		$this->Task->_scanFiles();
		$result = $this->Task->_parse();
		$expected = array(
			'addCss' => array(
				'single' => array('one_file'),
				':hash-default' => array('no_build')
			),
			'addScript' => array(
				'single' => array('one_file'),
				':hash-default' => array('no_build')
			)
		);
		$this->assertEqual($expected, $result);
	}
	
	function testParsingMultipleFile() {
		$files = array($this->testFilePath . 'multiple.ctp');
		$this->Task->setFiles($files);
		$this->Task->_scanFiles();
		$result = $this->Task->_parse();
		$expected = array(
			'addCss' => array(
				'multi' => array('one_file', 'two_file', 'three_file'),
			),
			'addScript' => array(
				'multi' => array('one_file', 'two_file', 'three_file'),
			)
		);
		$this->assertEqual($expected, $result);
	}

	function testParsingArrayFile() {
		$files = array($this->testFilePath . 'array.ctp');
		$this->Task->setFiles($files);
		$this->Task->_scanFiles();
		$result = $this->Task->_parse();

		$expected = array(
			'addCss' => array(
				':hash-default' => array('no', 'build'),
				'array_file' => array('has', 'a_build')
			),
			'addScript' => array(
				':hash-default' => array('no', 'build'),
				'multi_file' => array('one_file', 'two_file')
			)
		);
		$this->assertEqual($expected, $result);
	}
}
