THIS IS A WORK IN PROGRESS AND IN A STATE OF EXPERIMENTATION

DarkDissectBundle [![Build Status](https://travis-ci.org/cursedcoder/DarkDissectBundle.png?branch=master)](https://travis-ci.org/cursedcoder/DarkDissectBundle)
=================

Intro
-----
This is a Bundle, which integrates [Dissect](http://github.com/jakubledl/dissect) into your Symfony2 project.

Install
-------

Add dependency to your ``composer.json``:

```json
{
    "require": {
        "cursedcoder/dark-dissect-bundle": "*"
    }
}
```

Run ``composer update cursedcoder/dark-dissect-bundle``

Usage
-----
First of all, configure bundle in your Symfony2 app.

```yaml
dark_dissect:
    calculator:
        path: "%kernel.root_dir%/../calculator.yml"

    # my_cool_language:
    #     path: "%kernel.root_dir%/../my_cool_language.yml"
```

Now define lexis and grammar of your new language

```yaml
# calculator.yml
language:
    lexis:
        regex:
            int: '/[1-9][0-9]*/'
            wsp: '/[ \r\n\t]+/'
        tokens:
            - "("
            - ")"
            - "+"
            - "*"
            - "**"
        skip: [wsp]

    grammar:
        start_rule: additive
        default_context: Calculator
        rules:
            - additive:
                statement: [additive, +, multiplicative]
                call: ~ # will call calculator context, method additive by default
                # call: { context: MyCustomContext, method: MyCustomMethod }

            - additive:
                statement: [multiplicative]

            - multiplicative:
                statement: [multiplicative, *, power]
                call: ~

            - multiplicative:
                statement: [power]

            - power:
                statement: [primary, **, power]
                call: ~

            - power:
                statement: [primary]

            - primary:
                statement: [(, additive, )]
                call: ~

            - primary:
                statement: [int]
```

Now we are ready to describe language context.
Create a context class somewhere in your project.

```php
<?php

namespace Acme;

use Dark\DissectBundle\Context\ContextInterface;

class CalculatorContext implements ContextInterface
{
    public function getName()
    {
        return 'Calculator';
    }

    public function additive($left, $plus, $right)
    {
        return $left + $right;
    }

    public function multiplicative($left, $times, $right)
    {
        return $left * $right;
    }

    public function power($left, $pow, $right)
    {
        return pow($left, $right);
    }

    public function primary($l, $expr, $r)
    {
        return $expr;
    }
}
```

And define it as service, with ``dissect.context`` tag.

```yaml
services:
    my_calculator_context:
        class: Acme\CalculatorContext
        tags:
            - { name: dissect.context }
```

And finally use it:

```php
$language = $container->get('dissect.language_repository')->get('calculator');

echo $language->read('6 ** (1 + 1) ** 2 * (5 + 4)'); // 11664
```

Credits
=======
* Evgeniy Guseletov [cursedcoder](http://github.com/cursedcoder) [creator of bundle]
* Jakub Lédl [jakubledl](http://github.com/jakubledl) [creator of Dissect]
* [Other awesome developers](http://github.com/cursedcoder/DarkDissectBundle/contributors)
