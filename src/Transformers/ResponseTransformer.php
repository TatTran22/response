<?php

namespace TatTran\Response\Transformers;

use Illuminate\Pagination\AbstractPaginator as Paginator;
use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Manager;
use Illuminate\Support\Facades\Request;

class ResponseTransformer
{
    protected $fractalManager;

    public function __construct(Manager $fractalManager)
    {
        $this->fractalManager = $fractalManager;
        $this->parseIncludes();
    }

    public function parseIncludes()
    {
        $includeQuery = Request::query('include');

        if ($includeQuery) {
            $this->fractalManager->parseIncludes($includeQuery);
        }
    }

    public function setIncludes($include)
    {
        $this->fractalManager->parseIncludes($include);
    }

    public function transformData($data, $transformer)
    {
        if ($data instanceof Paginator) {
            $resource = new FractalCollection($data->items(), $transformer);

            $queryParams = array_diff_key(Request::query(), array_flip(['page']));
            $data->appends($queryParams);
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        } elseif ($data instanceof EloquentCollection) {
            $resource = new FractalCollection($data, $transformer);
        } else {
            $resource = new FractalItem($data, $transformer);
        }

        return $this->fractalManager->createData($resource)->toArray();
    }
}
