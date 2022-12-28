<?php

declare(strict_types=1);

namespace Enricky\CpfManager;

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
      $cpfNumber = rand(100000000, 999999999);
      $cpfString = strval($cpfNumber);
    } while (Cpf::isSequence($cpfString));

    $firstDigit = Self::createDigit($cpfString);
    $secondDigit = Self::createDigit($cpfString . $firstDigit);
    return Cpf::format($cpfString . $firstDigit . $secondDigit);
  }
  
  /**
   * Checa validade de um CPF.
   * @param string $cpf Cpf a ser validado. O CPF obrigatoriamente precisa estar no formato: 123.123.123-12 ou
   * 12312312312. Mesmo que os dígitos sejam válidos, caso a string não esteja nesses formatos, o retorno será falso.
   * @return bool `true` se o CPF for válido ou `false` caso não seja.
   */

  public static function validate(string $cpf): bool
  {
    $justNumbersRegex = "/^\d{11}$/";
    if (!preg_match($justNumbersRegex, $cpf) && !Self::validateFormat($cpf)) {
      return false;
    }

    $cleanCpf = Self::cleanUp($cpf);
    if (strlen($cleanCpf) !== 11 || Cpf::isSequence($cleanCpf)) {
      return false;
    }

    $partialCpf = substr($cleanCpf, 0, -2);
    $firstDigit = Self::createDigit($partialCpf);
    $secondDigit = Self::createDigit($partialCpf . $firstDigit);

    $newCpf = $partialCpf . $firstDigit . $secondDigit;
    return $cleanCpf === $newCpf;
  }

  /**
   * Checa se o formato do cpf enviado corresponde com o formato tradicional de CPF's: 999.999.999-99
   * @param string $cpf CPF a ser checado.
   * @return bool `true` se o formato corresponder ou `false` caso não.
   */

  public static function validateFormat(string $cpf): bool
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
    $cleanCpf = Self::cleanUp($cpf);
    if (strlen($cleanCpf) !== 11) {
      return null;
    }

    return preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "$1.$2.$3-$4", $cleanCpf);
  }

  /**
   * Remove todo tipo de caractere que não seja um dígito.
   * @param string $cpf CPF a ser limpado.
   * @return string O CPF com apenas dígitos.
   *
   * ex: 123.123.123-12 --> 12312312312
   */

  public static function cleanUp(string $cpf): string
  {
    return preg_replace("/\D+/", "", $cpf);
  }

  private static function createDigit(string $partialCpf): string
  {
    $cpfArray = str_split($partialCpf);
    $multiplicator = count($cpfArray) + 2;
    
    //multiplicator utilza a referência para ser possível alterar a variavel original dentro da função
    $cpfArray = array_map(function (string $digit) use (&$multiplicator) {
      $multiplicator--;
      return intval($digit) * $multiplicator;
    }, $cpfArray);

    $total = array_reduce($cpfArray, fn(int $count, int $number) => $count + $number, 0);

    $digit = 11 - ($total % 11);
    if ($digit > 9) {
      $digit = 0;
    }
    return strval($digit);
  }

  private static function isSequence(string $cpf): bool
  {
    $sequence = str_repeat($cpf[0], strlen($cpf));
    return $sequence === $cpf;
  }
}

