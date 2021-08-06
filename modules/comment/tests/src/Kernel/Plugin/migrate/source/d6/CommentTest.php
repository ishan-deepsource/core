<?php

namespace Drupal\Tests\comment\Kernel\Plugin\migrate\source\d6;

use Drupal\migrate\Row;
use Drupal\Tests\migrate\Kernel\MigrateSqlSourceTestBase;

/**
 * Tests D6 comment source plugin.
 *
 * @covers \Drupal\comment\Plugin\migrate\source\d6\Comment
 * @group comment
 */
class CommentTest extends MigrateSqlSourceTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['comment', 'd6_comment_test', 'migrate_drupal'];

  /**
   * @group legacy
   */
  public function testPrepareCommentDeprecation() {
    $this->expectDeprecation('Drupal\comment\Plugin\migrate\source\d6\Comment::prepareComment() is deprecated in drupal:9.3.0 and is removed from drupal:10.0.0. No direct replacement is provided. See https://www.drupal.org/node/3221964');
    $migration = $this->createMock('Drupal\migrate\Plugin\MigrationInterface');
    $mgr = \Drupal::service('plugin.manager.migrate.source');
    $plugin = $mgr->createInstance('d6_comment_test', [], $migration);
    $plugin->prepareComment(new Row());
  }

  /**
   * {@inheritdoc}
   */
  public function providerSource() {
    $tests = [];

    // The source data.
    $tests[0]['source_data']['comments'] = [
      [
        'cid' => 1,
        'pid' => 0,
        'nid' => 2,
        'uid' => 3,
        'subject' => 'subject value 1',
        'comment' => 'comment value 1',
        'hostname' => 'hostname value 1',
        'timestamp' => 1382255613,
        'status' => 0,
        'thread' => '',
        'name' => '',
        'mail' => '',
        'homepage' => '',
        'format' => 'testformat1',
        'type' => 'story',
      ],
      [
        'cid' => 2,
        'pid' => 1,
        'nid' => 3,
        'uid' => 4,
        'subject' => 'subject value 2',
        'comment' => 'comment value 2',
        'hostname' => 'hostname value 2',
        'timestamp' => 1382255662,
        'status' => 0,
        'thread' => '',
        'name' => '',
        'mail' => '',
        'homepage' => '',
        'format' => 'testformat2',
        'type' => 'page',
      ],
    ];

    $tests[0]['source_data']['node'] = [
      [
        'nid' => 2,
        'type' => 'story',
        'language' => 'en',
      ],
      [
        'nid' => 3,
        'type' => 'page',
        'language' => 'fr',
      ],
    ];

    // The expected results.
    $tests[0]['expected_data'] = [
      [
        'cid' => 1,
        'pid' => 0,
        'nid' => 2,
        'uid' => 3,
        'subject' => 'subject value 1',
        'comment' => 'comment value 1',
        'hostname' => 'hostname value 1',
        'timestamp' => 1382255613,
        'status' => 1,
        'thread' => '',
        'name' => '',
        'mail' => '',
        'homepage' => '',
        'format' => 'testformat1',
        'type' => 'story',
        'language' => 'en',
      ],
      [
        'cid' => 2,
        'pid' => 1,
        'nid' => 3,
        'uid' => 4,
        'subject' => 'subject value 2',
        'comment' => 'comment value 2',
        'hostname' => 'hostname value 2',
        'timestamp' => 1382255662,
        'status' => 1,
        'thread' => '',
        'name' => '',
        'mail' => '',
        'homepage' => '',
        'format' => 'testformat2',
        'type' => 'page',
        'language' => 'fr',
      ],
    ];

    return $tests;
  }

}
