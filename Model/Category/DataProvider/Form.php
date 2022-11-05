<?php
declare(strict_types=1);

namespace Am\Blog\Model\Category\DataProvider;

use Am\Blog\Api\Data\CategoryInterface;
use Am\Blog\Controller\Adminhtml\AbstractCategory;
use Am\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Form extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CategoryCollectionFactory $collectionFactory,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        $formData = $this->dataPersistor->get(AbstractCategory::DATA_PERSISTOR_KEY);
        if (!empty($formData)
            && is_array($formData)
        ) {
            $categoryId = $formData[CategoryInterface::CATEGORY_ID] ?? null;
            $this->dataPersistor->clear(AbstractCategory::DATA_PERSISTOR_KEY);
            $categoryData = $formData;
        } else {
            $categoryId = $this->request->getParam($this->getRequestFieldName());
            $category = $this->getCollection()
                ->addFieldToFilter(CategoryInterface::CATEGORY_ID, $categoryId)
                ->getFirstItem();
            if (!$category) {
                $category = $this->collection->getNewEmptyItem();
            }
            $categoryData = $category->getData();
        }
        $data[$categoryId] = $categoryData;

        return $data;
    }
}
