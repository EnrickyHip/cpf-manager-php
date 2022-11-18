# CPF MANAGER
Gerador, validador e gerenciador de CPF's para PHP.

## Instalação

```shell
$ composer require enricky/cpf-manager
```

## Utilização
```php
require_once __DIR__ . "/../vendor/autoload.php";
use Enricky\CpfManager\Cpf;
```


## Gere um CPF Válido aleatório

```php
$cpf = Cpf::generate();
echo $cpf; // 147.001.216-29
```

## Valide um CPF

```php
$cpfValido = Cpf::validate('147.001.216-29');
var_dump($cpfValido); //bool(true)

$cpfInvalido = Cpf::validate('111.111.111-11');
var_dump($cpfInvalido); //bool(false)
```

## Formate um CPF

```php
$cpfFormatado = Cpf::format('14700121629');
echo $cpfFormatado; // 147.001.216-29
```

## Valide o formato de um CPF

```php
$formatoValido = Cpf::validate_format('147.001.216-29');
var_dump($formatoValido); //bool(true)

$formatoInvalido = Cpf::validate_format('147-001-216-29');
var_dump($formatoInvalido); //bool(false)
```

## Limpe um CPF

```php
$cpfLimpo = Cpf::clean_up('147.001.216-29');
echo $cpfLimpo; // 14700121629
```
