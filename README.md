# Tattran22/Response

Tattran22/Response is a Laravel package designed to handle response transformation using the Fractal library. It provides a convenient way to transform your API responses, including pagination support and includes parsing.

## Installation

You can install the package via Composer. Run this command in your terminal:

```bash
composer require tattran22/response
```

The package will automatically register itself.

## Usage

### Basic Usage

First, make sure your data is prepared in a format that can be transformed, such as Eloquent models or plain arrays. Then, create a transformer class to specify how your data should be transformed.

```php
use Tattran22\Response\Transformers\ResponseTransformer;

$transformer = new ResponseTransformer($manager);
$response = $transformer->transformData($data, $transformerInstance);
```

### Including Relationships

You can include relationships in your response by specifying them in the `include` query parameter. For example:

```
http://example.com/api/resource?include=relationship
```

### Pagination

If your data is paginated, the package will automatically handle pagination links and metadata.

### Set Includes

You can set includes programmatically using the `setIncludes` method.

```php
$transformer->setIncludes(['include1', 'include2']);
```

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

This package is developed and maintained by [Tat Tran](https://github.com/tattran22).
