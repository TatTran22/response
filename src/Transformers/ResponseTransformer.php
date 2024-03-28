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

    /**
     * @param Manager $fractalManager
     */
    public function __construct(Manager $fractalManager)
    {
        $this->fractalManager = $fractalManager;
        $this->parseIncludes();
    }

    /**
     * @return void
     */
    public function parseIncludes()
    {
        $includeQuery = Request::query('include');

        if ($includeQuery) {
            $this->fractalManager->parseIncludes($includeQuery);
        }
    }

    /**
     * @param $include
     * @return void
     */
    public function setIncludes($include)
    {
        $this->fractalManager->parseIncludes($include);
    }

    /**
     * @param $entity
     * @param $transformer
     * @return array|null
     */
    public function transform($entity, $transformer)
    {
        if ($entity instanceof Paginator) {
            $resource = new FractalCollection($entity->getCollection(), $transformer);

            $queryParams = array_diff_key(Request::query(), array_flip(['page']));
            $entity->appends($queryParams);
            $resource->setPaginator(new IlluminatePaginatorAdapter($entity));

        } elseif ($entity instanceof EloquentCollection) {
            $resource = new FractalCollection($entity, $transformer);

        } else {
            $resource = new FractalItem($entity, $transformer);

        }
        return $this->fractalManager->createData($resource)->toArray();
    }
}
