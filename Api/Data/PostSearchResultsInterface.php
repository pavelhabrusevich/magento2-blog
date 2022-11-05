<?php
declare(strict_types=1);

namespace Am\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get posts list.
     *
     * @return \Am\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set posts list.
     *
     * @param \Am\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
