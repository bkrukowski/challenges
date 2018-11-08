# Challenges

[![Build Status](https://travis-ci.org/bkrukowski/challenges.svg?branch=master)](https://travis-ci.org/bkrukowski/challenges)

1) `bkrukowski\Challenges\strShort`
2) `bkrukowski\Challenges\sortWords`
3) `bkrukowski\Challenges\findUnique`
4) `bkrukowski\Challenges\Encoder\*`, e.g.:

```php
<?php

use bkrukowski\Challenges\Encoder\Encoder;
use bkrukowski\Challenges\Encoder\KeyFactory;

$stringKey = '123heyO';
$encoder = new Encoder((new KeyFactory())->create($stringKey));
$encoded = $encoder->encode('My secret mesage');
$decoded = $encoder->decode($encoded);
```
