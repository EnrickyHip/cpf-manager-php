<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use Enricky\CpfManager\Cpf;

//* validateFormat

it("should validate format", function (string $cpf) {
  expect(Cpf::validateFormat($cpf))->toBeTrue();
})->with(["000.000.000-00", "999.999.999-99"]);

it("should not validate format", function (string $cpf) {
  expect(Cpf::validateFormat($cpf))->toBeFalse();
})->with("invalid_formats");

//* generate

it("should generate cpf with valid format", function () {
  for ($i = 0; $i < 15; $i++) {
    $cpf = Cpf::generate();
    expect(Cpf::validateFormat($cpf))->toBeTrue();
  }
});

it("should generate valid CPF", function () {
  for ($i = 0; $i < 15; $i++) {
    $cpf = Cpf::generate();
    expect(Cpf::validate($cpf))->toBeTrue();
  }
});

//* validate

it("should return false if cpf has not 11 digits", function (string $cpf) {
  expect(Cpf::validate($cpf))->toBeFalse();
})->with("non_11_digits");

it("should not validate when format is not correct", function (string $cpf) {
  expect(Cpf::validate($cpf))->toBeFalse();
})->with("valid_but_not_formated_cpfs");

it("should not validate when cpf is sequence", function (string $cpf) {
  expect(Cpf::validate($cpf))->toBeFalse();
})->with("sequences");

it("should not validate when cpf is not valid", function (string $cpf) {
  expect(Cpf::validate($cpf))->toBeFalse();
})->with("invalid_cpfs");

it("should validate cpfs", function (string $cpf) {
  expect(Cpf::validate($cpf))->toBeTrue();
})->with("valid_cpfs");

//* format

it("should return null if is not possible to format cpf", function (string $cpf) {
  expect(Cpf::format($cpf))->toBeNull();
})->with("non_11_digits");

it("should format cpf", function () {
  expect(Cpf::format("27303239456"))->toBe("273.032.394-56");
  expect(Cpf::format("649.98136054"))->toBe("649.981.360-54");
  expect(Cpf::format("652-809-610-43"))->toBe("652.809.610-43");
  expect(Cpf::format("289 asasa88a  sassa7.56as002"))->toBe("289.887.560-02");
});

it("should format not formated cpfs and validate it", function (string $cpf) {
  $formated_cpf = Cpf::format($cpf);
  expect(Cpf::validateFormat($formated_cpf))->toBeTrue();
  expect(Cpf::validate($formated_cpf))->toBeTrue();
})->with("valid_but_not_formated_cpfs");

//* cleanUp

it("should clean up cpf", function () {
  expect(Cpf::cleanUp("273.032.394-56"))->toBe("27303239456");
  expect(Cpf::cleanUp("649.98136054"))->toBe("64998136054");
  expect(Cpf::cleanUp("652-809-610-43"))->toBe("65280961043");
  expect(Cpf::cleanUp("289 asasa88a  sassa7.56as002"))->toBe("28988756002");
});

