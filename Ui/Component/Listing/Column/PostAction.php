<?php
declare(strict_types=1);

namespace Am\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class PostAction extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => '/edit',
                        'label' => __('Edit')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
