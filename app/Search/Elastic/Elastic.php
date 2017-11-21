<?php

namespace GetCandy\Search\Elastic;

use Elastica\Client;
use Elastica\Document;
use Elastica\Status;
use Elastica\Type\Mapping;
use GetCandy\Api\Products\Models\Product;
use GetCandy\Search\Elastic\Indexers\ProductIndexer;
use GetCandy\Search\SearchContract;
use Illuminate\Database\Eloquent\Model;
use Elastica\Aggregation\Terms;
use Elastica\Aggregation\Nested as NestedAggregation;
use Elastica\Query\Nested as NestedQuery;
use Elastica\Query\Match;

class Elastic implements SearchContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var mixed
     */
    protected $indexer;

    /**
     * @var string
     */
    protected $lang = 'en';

    /**
     * @var array
     */
    protected $indexers = [
        Product::class => ProductIndexer::class,
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function language($lang = 'en')
    {
        $this->lang = $lang;
        return $this;
    }

    public function against($types)
    {
        $this->indexer = $this->getIndexer($types);
        return $this;
    }
    /**
     * Checks whether an indexer exists
     * @param  mixed  $model
     * @return boolean
     */
    public function hasIndexer($model)
    {
        if (is_object($model)) {
            $model = get_class($model);
        }
        return isset($this->indexers[$model]);
    }

    /**
     * Adds a model to the index
     * @param  Model  $model
     * @return boolean
     */
    public function indexObject(Model $model)
    {
        // Get the indexer.
        // $indexer = $this->getIndexer($model);
        // $index =
        // $elasticaType = $index->getType($indexer->type);
        // $response = $elasticaType->addDocument($indexer->getIndexDocument($model));

        $this->against($model);

        $indexables = $this->indexer->getIndexDocument($model);

        foreach ($indexables as $indexable) {
            $index = $this->getIndex($indexable->getIndex());

            $elasticaType = $index->getType($this->indexer->type);

            $document = new Document(
                $indexable->getId(),
                $indexable->getData()
            );

            $response = $elasticaType->addDocument($document);
        }
        return true;
    }

    public function reset($index)
    {
        if ($this->hasIndex($index)) {
            $this->client()->getIndex($index)->delete();
        }
    }

    /**
     * Updates the mappings for the model
     * @param  Elastica\Index $index
     * @return void
     */
    public function updateMappings($index)
    {
        $elasticaType = $index->getType($this->indexer->type);

        $mapping = new Mapping();
        $mapping->setType($elasticaType);

        $mapping->setProperties($this->indexer->mapping());
        $mapping->send();
    }

    /**
     * Create an index based on the model
     * @return void
     */
    public function createIndex()
    {
        $index = $this->client()->getIndex('getcandy');
        $index->create();
    }

    /**
     * Gets the client for the model
     * @return Elastica\Client
     */
    public function client()
    {
        if (! $this->client) {
            return new Client();
        }
        return $this->client;
    }

    public function hasIndex($name)
    {
        $elasticaStatus = new Status($this->client());
        return $elasticaStatus->indexExists($name) or $elasticaStatus->aliasExists($name);
    }

    /**
     * Returns the index for the model
     * @return Elastica\Index
     */
    public function getIndex($name = null)
    {
        $index = $this->client()->getIndex($name);

        if (!$this->hasIndex($name)) {
            // Requested index does not exist
            $index->create();
            // $index->setSettings();
            // ...and create it's alias name
            //$index->addAlias($this->indexName);
            // ...and update the mappings
            $this->updateMappings($index);
        }

        return $index;
    }

    public function with($searchterm)
    {
        return $this->search($searchterm);
    }

    protected function getSearchIndex($indexer)
    {
        return config('search.index_prefix') . $this->lang;
    }

    /**
     * Searches the index
     * @param  string $keywords
     * @return array
     */
    public function search($keywords, $filters = [])
    {
        if (!$this->indexer) {
            abort(400, 'You need to set an indexer first');
        }

        $search = new \Elastica\Search($this->client);

        $search
            ->addIndex(config('search.index_prefix') . '_' .  $this->lang)
            ->addType($this->indexer->type);


        $boolQuery = new \Elastica\Query\BoolQuery;

        $disMaxQuery = $this->generateDisMax($keywords);

        $boolQuery->addMust($disMaxQuery);

        // Terms aggregation...
        // $termsAgg = new Terms("genders");
        // $termsAgg->setField("gender");
        // $termsAgg->setSize(10);

        $query = new \Elastica\Query();

        $query
            ->setQuery($boolQuery)
            ->setHighlight(array(
                'pre_tags' => array('<em class="highlight">'),
                'post_tags' => array('</em>'),
                'fields' => array(
                    'name' => array(
                        'number_of_fragments' => 0,
                    ),
                    'description' => array(
                        'number_of_fragments' => 0,
                    ),
                ),
            ));
        
        // TODO: This needs to allow for multiple categories being set.
        if (!empty($filters['categories'])) {

            foreach ($filters['categories']['values'] as $value) {

            }
            $postFilter = new NestedQuery();
            $postFilter->setPath('departments');
        
            $postFilterQuery = new Match;
            $postFilterQuery->setField('departments.id', $filters['category']);

            $postFilter->setQuery($postFilterQuery);
        
            $query->setPostFilter($postFilter);
        }

        $search->setQuery($query);

        $results = $search->search();
        return $results;
    }

    protected function getCategoryFilter()
    {

    }

    protected function generateAggregates()
    {

    }

    protected function generateDisMax($keywords)
    {
        $disMaxQuery = new \Elastica\Query\DisMax();
        $disMaxQuery->setBoost(1.5);
        $disMaxQuery->setTieBreaker(1);

        $multiMatchQuery = new \Elastica\Query\MultiMatch();
        $multiMatchQuery->setType('phrase');
        $multiMatchQuery->setQuery($keywords);
        $multiMatchQuery->setFields($this->indexer->rankings());

        $disMaxQuery->addQuery($multiMatchQuery);

        $multiMatchQuery = new \Elastica\Query\MultiMatch();
        $multiMatchQuery->setType('best_fields');
        $multiMatchQuery->setQuery($keywords);

        $multiMatchQuery->setFields($this->indexer->rankings());

        $disMaxQuery->addQuery($multiMatchQuery);

        return $disMaxQuery;
    }

    /**
     * Gets the indexer for a model
     * @param  mixed $model
     * @return mixed
     */
    protected function getIndexer($model)
    {
        if (is_object($model)) {
            $model = get_class($model);
        }
        if (!$this->hasIndexer($model)) {
            abort(400, "No indexer available for {$model}");
        }
        return new $this->indexers[$model];
    }
}
