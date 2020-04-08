#yandex-money-parser

PHP library (class) to parse yandex money response text

###Run tests using one of options:
- `composer tests`
- `php vendor/bin/phpunit`

### Usage example:
```
$parser = new YandexMoneyParser($message);
echo $parser->getCode(); 
echo $parser->getAmount();
echo $parser->getWallet();
```

### Requirements:
- `php 7.1+`
