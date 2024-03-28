## TatTran22/Response: Easy API Response Transformation for Laravel

This Laravel package simplifies handling API responses using the Fractal library. It lets you easily:

* **Transform data:** Convert raw data into structured responses.
* **Include relationships:** Add related data to your responses without separate requests.
* **Handle pagination:** Automatically add pagination links and metadata.

## Installation

Just run this command in your terminal:

```bash
composer require tattran22/response
```

## Usage

1. **Prepare your data:** Use Eloquent models, arrays, or any suitable format.
2. **Create a transformer:** Define how to transform your data using a `ResponseTransformer` class.
3. **Transform your data:** Call `transformData` with your data and transformer.
   ```php
   use TatTran\Response\Transformers\ResponseTransformer;

   $transformer = new ResponseTransformer($manager);
   $response = $transformer->transformData($data, $transformerInstance);
    ```
4. **(Optional) Include relationships:** Add `include` parameters to your API requests (e.g., `?include=relationship`).
    ```php
    $transformer->setIncludes(['include1', 'include2']);
    ```
## Features

* **Easy transformation:** Define transformations in clear, readable code.
* **Includes parsing:** Automatically handle `include` query parameters.
* **Pagination support:** Add pagination links and metadata seamlessly.
* **Set includes programmatically:** Control included relationships in code.

## Open Source & Credits

This package is free to use under the MIT license and developed by [Tat Tran](https://tattran.com).
