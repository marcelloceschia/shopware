<?php declare(strict_types=1);

namespace Shopware\Product\Gateway\Resource;

use Shopware\Framework\Api2\ApiFlag\Required;
use Shopware\Framework\Api2\Field\FkField;
use Shopware\Framework\Api2\Field\IntField;
use Shopware\Framework\Api2\Field\ReferenceField;
use Shopware\Framework\Api2\Field\StringField;
use Shopware\Framework\Api2\Field\BoolField;
use Shopware\Framework\Api2\Field\DateField;
use Shopware\Framework\Api2\Field\SubresourceField;
use Shopware\Framework\Api2\Field\LongTextField;
use Shopware\Framework\Api2\Field\LongTextWithHtmlField;
use Shopware\Framework\Api2\Field\FloatField;
use Shopware\Framework\Api2\Field\TranslatedField;
use Shopware\Framework\Api2\Field\UuidField;
use Shopware\Framework\Api2\Resource\ApiResource;

class ProductDownloadResource extends ApiResource
{
    public function __construct()
    {
        parent::__construct('product_download');
        
        $this->primaryKeyFields['uuid'] = (new UuidField('uuid'))->setFlags(new Required());
        $this->fields['productId'] = (new IntField('product_id'))->setFlags(new Required());
        $this->fields['description'] = (new StringField('description'))->setFlags(new Required());
        $this->fields['fileName'] = (new StringField('file_name'))->setFlags(new Required());
        $this->fields['size'] = (new FloatField('size'))->setFlags(new Required());
        $this->fields['product'] = new ReferenceField('productUuid', 'uuid', \Shopware\Product\Gateway\Resource\ProductResource::class);
        $this->fields['productUuid'] = (new FkField('product_uuid', \Shopware\Product\Gateway\Resource\ProductResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['attributes'] = new SubresourceField(\Shopware\Product\Gateway\Resource\ProductDownloadAttributeResource::class);
    }
    
    public function getWriteOrder(): array
    {
        return [
            \Shopware\Product\Gateway\Resource\ProductResource::class,
            \Shopware\Product\Gateway\Resource\ProductDownloadResource::class,
            \Shopware\Product\Gateway\Resource\ProductDownloadAttributeResource::class
        ];
    }
}