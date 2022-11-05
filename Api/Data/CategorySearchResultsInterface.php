<?php
declare(strict_types=1);

namespace Am\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get categories list.
     *
     * @return \Am\Blog\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * Set categories list.
     *
     * @param \Am\Blog\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
