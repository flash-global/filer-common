# Service Filer - Common

[![GitHub release](https://img.shields.io/github/release/flash-global/filer-common.svg?style=for-the-badge)](README.md)

## Table of contents
- [Entities](#entities)
- [Validators](#validators)
- [Contribution](#contribution)

## Entities

### File entity

In addition to traditional ID and CreatedAt fields, File Entity has **six** important properties:

| Property    | Type              |
|-------------|-------------------|
| uuid        | `string`          |
| revision    | `integer`         |
| category    | `integer`         |
| contentType | `string`          |
| data        | `string`          |
| filename    | `string`          |
| file        | `SplFileObject`   |
| contexts    | `ArrayCollection` |

- `$uuid` (Universal Unique Identifier) is a **unique id** corresponding to a file. Its format is based on
  **36 characters** as defined in `RFC4122` prefixed by a **backend id** and separated by a `:`.
  Example: `bck1:f6461366-a414-4b98-a76d-d7b190252e74`
- `revision` is an integer indicating the file's current revision.
- `category` is an integer defining in which database the file will be stored in.
- `contentType` defines the content type of the `File` object.
- `data` contains the file's content.
- `filename` contains the file's filename.
- `file` is an `SplFileObject` instance. (see https://secure.php.net/manual/en/class.splfileobject.php for more details)
- `contexts` is an `ArrayCollection` instance where each element is a Context entity

### Context entity

In addition to traditional ID field, Context Entity has **three** important properties:

| Property    | Type              |
|-------------|-------------------|
| key         | `string`          |
| value       | `string`          |
| file        | `File`            |

- `key` is a string defining the context's key.
- `value` is a string defining the context's value
- `file` is a File object indicating the context's related file

## Validators

You have the possibility to validate a `File` entity with `FileValidator` class:

```php
<?php

use Fei\Service\Filer\Validator\FileValidator;
use Fei\Service\Filer\Entity\File;

$fileValidator = new FileValidator();
$file = new File();

//validate returns true if your File instance is valid, or false in the other case
$isFileValid = $fileValidator->validate($file);

//getErrors() allows you to get an array of errors if there are some, or an empty array in the other case
$errors = $fileValidator->getErrors();
```

By default, all `File` properties must **not** be empty,
but you're also able to validate only a few properties of your entity, using `validate` methods:

```php
<?php

use Fei\Service\Filer\Validator\FileValidator;
use Fei\Service\Filer\Entity\File;

$fileValidator = new FileValidator();

$file = new File();
$file->setUuid('uuid');
$file->setRevision(1);

$fileValidator->validateUuid($file->getUuid());
$fileValidator->validateRevision($file->getRevision());

// will return an empty array : all of our definitions are correct
$errors = $fileValidator->getErrors();
echo empty($errors); // true

// contentType can not be empty, let's try to set it as an empty string
$file->setContentType('');
$fileValidator->validateContentType($file->getContentType());

// this time you'll get a non-empty array
$errors = $fileValidator->getErrors();

echo empty($errors); // false
print_r($errors);

/**
* print_r will return:
*
*    Array
*    (
*        ['contentType'] => Array
*            (
*                'Content-Type cannot be empty'
*            )
*    )
**/
```

### Context validator

You have the possibility to validate a `Context` entity with `ContextValidator` class:

```php
<?php

use Fei\Service\Filer\Validator\ContextValidator;
use Fei\Service\Filer\Entity\File;
use Fei\Service\Filer\Entity\Context;

$contextValidator = new ContextValidator();
$file = new File();
$context = new Context([
    'key' => 'my_key',
    'value' => 'my_value',
    'file' => $file
]);

//validate returns true if your Context instance is valid, or false in the other case
$isContextValid = $contextValidator->validate($context);

//getErrors() allows you to get an array of errors if there are some, or an empty array in the other case
$errors = $contextValidator->getErrors();
```

By default, all `Context` properties must **not** be empty,
but you're also able to validate only a few properties of your entity, using `validate` methods:

```php
<?php

use Fei\Service\Filer\Validator\ContextValidator;
use Fei\Service\Filer\Entity\Context;

$contextValidator = new ContextValidator();
$context = new Context();
$context->setKey('key');
$context->setValue('value');

$contextValidator->validateKey($context->getKey());
$contextValidator->validateValue($context->getValue());

// will return an empty array : all of our definitions are correct
$errors = $contextValidator->getErrors();
echo empty($errors); // true
```

## Contribution
As FEI Service, designed and made by OpCoding. The contribution workflow will involve both technical teams. Feel free to contribute, to improve features and apply patches, but keep in mind to carefully deal with pull request. Merging must be the product of complete discussions between Flash and OpCoding teams :) 







