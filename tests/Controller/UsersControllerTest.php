<?php

namespace Drupal\my_users\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_users module.
 */
class UsersControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_users UsersController's controller functionality",
      'description' => 'Test Unit for module my_users and controller UsersController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests my_users functionality.
   */
  public function testUsersController() {
    // Check that the basic functions of module my_users.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
