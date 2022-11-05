<?php
declare(strict_types=1);

namespace Am\Blog\Model\ResourceModel\Post;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Api\Data\PostInterfaceFactory;
use Am\Blog\Api\Data\PostSearchResultsInterface;
use Am\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use Am\Blog\Api\PostRepositoryInterface;
use Am\Blog\Model\Post as PostModel;
use Am\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Am\Blog\Model\ResourceModel\Post\CollectionFactory;
use Am\Blog\Model\ResourceModel\Post\Post as PostResourceModel;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var PostSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var PostResourceModel
     */
    private $postResource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var PostInterfaceFactory
     */
    private $postInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    public function __construct(
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        PostResourceModel $postResource,
        CollectionFactory $collectionFactory,
        PostInterfaceFactory $postInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        CollectionProcessorInterface $collectionProcessor,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->postResource = $postResource;
        $this->collectionFactory = $collectionFactory;
        $this->postInterfaceFactory = $postInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    public function getById(int $postId): PostInterface
    {
        if (!isset($this->registry[$postId])) {
            /** @var PostInterface $post */
            $post = $this->postInterfaceFactory->create();
            $this->postResource->load($post, $postId);
            if (!$post->getId()) {
                throw NoSuchEntityException::singleField('id', $postId);
            }
            $this->registry[$postId] = $post;
        }

        return $this->registry[$postId];
    }

    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->postResource->save($post);
            $this->registry[$post->getId()] = $post;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $post;
    }

    public function delete(PostInterface $post): bool
    {
        try {
            $this->postResource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        if (isset($this->registry[$post->getId()])) {
            unset($this->registry[$post->getId()]);
        }

        return true;
    }

    public function deleteById(int $postId): bool
    {
        return $this->delete($this->getById($postId));
    }

    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultsInterface
    {
        /** @var PostCollection $collection */
        $collection = $this->collectionFactory->create();

//        $this->extensionAttributesJoinProcessor->process($collection, PostInterface::class);
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var PostSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        $objects = [];
        /** @var PostModel $item */
        foreach ($collection->getItems() as $item) {
            $objects[] = $this->getDataObject($item);
        }
        $searchResults->setItems($objects);

        return $searchResults;
    }

    private function getDataObject(PostModel $model): PostInterface
    {
        /** @var PostInterface $object */
        $object = $this->postInterfaceFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $object,
            $this->dataObjectProcessor->buildOutputDataArray($model, PostInterface::class),
            PostInterface::class
        );

        return $object;
    }
}
