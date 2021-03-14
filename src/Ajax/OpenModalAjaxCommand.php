<?php

namespace Drupal\my_users\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Class OpenModalAjacCommand.
 */
class OpenModalAjaxCommand implements CommandInterface {

  /**
   * @var int
   */
  protected int $id;

  /**
   * @var string
   */
  protected string $name;

  /**
   * @param int $id
   *   Param Id.
   * @param string $name
   *   Param name.
   */
  public function __construct(int $id, string $name) {
    $this->id = $id;
    $this->name = $name;
  }

  /**
   * Render custom ajax command.
   *
   * @return ajax
   *   Command function.
   */
  public function render() {
    return [
      'command' => 'example',
      'id' => $this->id,
      'name' => $this->name,
    ];
  }

}
