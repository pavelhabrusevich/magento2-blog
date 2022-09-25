<?php
declare(strict_types=1);

namespace Am\Blog\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PostStatus implements OptionSourceInterface
{
    public const DISABLED = 0;
    public const ENABLED = 1;

    public function toOptionArray()
    {
        return [
            ['value' => self::DISABLED, 'label' => __('Disabled')],
            ['value' => self::ENABLED, 'label' => __('Enabled')]
        ];
    }
}
