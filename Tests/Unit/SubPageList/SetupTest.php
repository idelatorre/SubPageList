<?php

namespace Tests\Unit\SubPageList;

use SubPageList\Setup;

/**
 * @covers SubPageList\Setup
 *
 * @group SubPageList
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SetupTest extends \PHPUnit_Framework_TestCase {

	public function testRun() {
		$extension = $this->newExtension();

		$hookLists = array(
			'ParserFirstCallInit' => array(),
			'ArticleInsertComplete' => array(),
			'ArticleDeleteComplete' => array(),
			'TitleMoveComplete' => array(),
			'UnitTestsList' => array(),
		);

		$setup = new Setup(
			$extension,
			$hookLists,
			__DIR__ . '/..'
		);

		$setup->run();

		foreach ( $hookLists as $hookName => $hookList ) {
			$this->assertEquals( 1, count( $hookList ), "one hook handler need to be added to '$hookName'" );

			$hook = reset( $hookList );

			$this->assertInternalType( 'callable', $hook );
		}
	}

	protected function newExtension() {
		return new \SubPageList\Extension( \SubPageList\Settings::newFromGlobals( $GLOBALS ) );
	}

}
