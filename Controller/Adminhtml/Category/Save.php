<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Category;

use Am\Blog\Api\Data\CategoryInterface;
use Am\Blog\Api\CategoryRepositoryInterface;
use Am\Blog\Controller\Adminhtml\AbstractCategory;
use Am\Blog\Model\CategoryFactory as CategoryFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends AbstractCategory
{
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        DataPersistorInterface $dataPersistor,
        CategoryRepositoryInterface $categoryRepository,
        DataObjectHelper $dataObjectHelper,
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->dataPersistor = $dataPersistor;
        $this->dataObjectHelper = $dataObjectHelper;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            try {
                $categoryId = isset($data[CategoryInterface::CATEGORY_ID])
                    ? (int)$data[CategoryInterface::CATEGORY_ID]
                    : false;
                $model = $categoryId
                    ? $this->categoryRepository->getById($categoryId)
                    : $this->categoryFactory->create();

                $this->dataObjectHelper->populateWithArray($model, $data, CategoryInterface::CATEGORY_ID);
                $this->categoryRepository->save($model);
                $this->dataPersistor->clear(self::DATA_PERSISTOR_KEY);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $this->resultRedirectFactory->create()->setPath(
                        '*/*/edit',
                        [CategoryInterface::CATEGORY_ID => $model->getId()]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the category')
                );
            }
            $this->dataPersistor->set(CategoryInterface::CATEGORY_ID, $data);
            $categoryId = isset($data[CategoryInterface::CATEGORY_ID])
                ? (int)$data[CategoryInterface::CATEGORY_ID]
                : false;
            if ($categoryId) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $categoryId, '_current' => true]);
            }

            return $resultRedirect->setPath('*/*/new', ['_current' => true]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
