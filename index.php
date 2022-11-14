<?php

declare(strict_types=1);

class Cpf
{
  const REGEX = "/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})$/";

  public static function generate(): string
  {
    do {
      $cpf_number = rand(100000000, 999999999);
      $cpf_string = (string)$cpf_number;
    } while (Cpf::is_sequence($cpf_string));

    $first_digit = Self::create_digit($cpf_string);
    $second_digit = Self::create_digit($cpf_string . $first_digit);
    return $cpf_string . $first_digit . $second_digit;
  }

  public static function validate(string $cpf): bool
  {
    $just_numbers_regex = "/^\d{11}$/";
    if (!preg_match($just_numbers_regex, $cpf) && !Self::validate_format($cpf)) {
      return false;
    }

    $clean_cpf = Self::clean_up($cpf);
    if (strlen($clean_cpf) !== 11 || Cpf::is_sequence($clean_cpf)) {
      return false;
    }

    $partial_cpf = substr($clean_cpf, 0, -2);
    $first_digit = Self::create_digit($partial_cpf);
    $second_digit = Self::create_digit($partial_cpf . $first_digit);

    $new_cpf = $partial_cpf . $first_digit . $second_digit;
    return $clean_cpf === $new_cpf;
  }

  public static function validate_format(string $cpf)
  {
    return preg_match(Self::REGEX, $cpf);
  }

  public static function format(string $cpf): string
  {
    $clean_cpf = Self::clean_up($cpf);
    return preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "$1.$2.$3-$4", $clean_cpf);
  }

  public static function clean_up(string $cpf): string
  {
    return preg_replace("/\D+/", "", $cpf);
  }

  private static function create_digit(string $partial_cpf): string
  {
    $cpf_array = str_split($partial_cpf);
    $multiplicator = count($cpf_array) + 2;
    
    //multiplicator utilza a referência para ser possível alterar a variavel original dentro da função
    $cpf_array = array_map(function (string $digit) use (&$multiplicator) {
      $multiplicator--;
      return (int)$digit * $multiplicator;
    }, $cpf_array);

    $total = array_reduce($cpf_array, fn(int $count, int $number) => $count + $number, 0);

    $digit = 11 - ($total % 11);
    if ($digit > 9) {
      $digit = 0;
    }
    return strval($digit);
  }

  private static function is_sequence(string $cpf): bool
  {
    $sequence = str_repeat($cpf[0], strlen($cpf));
    return $sequence === $cpf;
  }
}
