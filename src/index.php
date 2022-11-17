<?php

declare(strict_types=1);

namespace Enricky\Cpf;

class Cpf
{
  const REGEX = "/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})$/";

  /**
   * Gera um CPF válido.
   * @return string cpf no formato: 999.999.999-99.
   */

  public static function generate(): string
  {
    do {
      $cpf_number = rand(100000000, 999999999);
      $cpf_string = strval($cpf_number);
    } while (Cpf::is_sequence($cpf_string));

    $first_digit = Self::create_digit($cpf_string);
    $second_digit = Self::create_digit($cpf_string . $first_digit);
    return Cpf::format($cpf_string . $first_digit . $second_digit);
  }
  
  /**
   * Checa validade de um CPF.
   * @param string $cpf Cpf a ser validado. O CPF obrigatoriamente precisa estar no formato: 123.123.123-12 ou
   * 12312312312. Mesmo que os dígitos sejam válidos, caso a string não esteja nesses formatos, o retorno será falso.
   * @return bool `true` se o CPF for válido ou `false` caso não seja.
   */

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

  /**
   * Checa se o formato do cpf enviado corresponde com o formato tradicional de CPF's: 999.999.999-99
   * @param string $cpf CPF a ser checado.
   * @return bool `true` se o formato corresponder ou `false` caso não.
   */

  public static function validate_format(string $cpf): bool
  {
    return boolval(preg_match(Self::REGEX, $cpf));
  }

  /**
   * Formata um CPF no formato: 999.999.999-99.
   * @param string $cpf CPF a ser formatado. Esse parâmetro é extremamente livre,
   * pois a função filtra tudo que não for dígito.
   * @return string|null O CPF formatado. Caso não seja possível formatar o cpf por não possuir a quantidade
   * necessária de caracteres, o retorno será `null`
   *
   */

  public static function format(string $cpf): string | null
  {
    $clean_cpf = Self::clean_up($cpf);
    if (strlen($clean_cpf) !== 11) {
      return null;
    }

    return preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "$1.$2.$3-$4", $clean_cpf);
  }

  /**
   * Remove todo tipo de caractere que não seja um dígito.
   * @param string $cpf CPF a ser limpado.
   * @return string O CPF com apenas dígitos.
   *
   * ex: 123.123.123-12 --> 12312312312
   */

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
      return intval($digit) * $multiplicator;
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
