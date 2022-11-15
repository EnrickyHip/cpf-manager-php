<?php

declare(strict_types=1);

require_once __DIR__ . "/../src/index.php";

use Enricky\Cpf\Cpf;

it("should validate format", function (string $cpf) {
  expect(Cpf::validate_format($cpf))->toBeTrue();
})->with(["000.000.000-00", "999.999.999-99"]);



