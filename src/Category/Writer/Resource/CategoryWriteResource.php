<?php declare(strict_types=1);

namespace Shopware\Category\Writer\Resource;

use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Write\Field\BoolField;
use Shopware\Framework\Write\Field\FkField;
use Shopware\Framework\Write\Field\IntField;
use Shopware\Framework\Write\Field\LongTextField;
use Shopware\Framework\Write\Field\ReferenceField;
use Shopware\Framework\Write\Field\StringField;
use Shopware\Framework\Write\Field\SubresourceField;
use Shopware\Framework\Write\Field\TranslatedField;
use Shopware\Framework\Write\Field\UuidField;
use Shopware\Framework\Write\Flag\Required;
use Shopware\Framework\Write\WriteResource;

class CategoryWriteResource extends WriteResource
{
    protected const UUID_FIELD = 'uuid';
    protected const PATH_FIELD = 'path';
    protected const POSITION_FIELD = 'position';
    protected const LEVEL_FIELD = 'level';
    protected const TEMPLATE_FIELD = 'template';
    protected const ACTIVE_FIELD = 'active';
    protected const IS_BLOG_FIELD = 'isBlog';
    protected const EXTERNAL_FIELD = 'external';
    protected const HIDE_FILTER_FIELD = 'hideFilter';
    protected const HIDE_TOP_FIELD = 'hideTop';
    protected const PRODUCT_BOX_LAYOUT_FIELD = 'productBoxLayout';
    protected const PRODUCT_STREAM_UUID_FIELD = 'productStreamUuid';
    protected const HIDE_SORTINGS_FIELD = 'hideSortings';
    protected const SORTING_UUIDS_FIELD = 'sortingUuids';
    protected const FACET_UUIDS_FIELD = 'facetUuids';
    protected const NAME_FIELD = 'name';
    protected const PATH_NAMES_FIELD = 'pathNames';
    protected const META_KEYWORDS_FIELD = 'metaKeywords';
    protected const META_TITLE_FIELD = 'metaTitle';
    protected const META_DESCRIPTION_FIELD = 'metaDescription';
    protected const CMS_HEADLINE_FIELD = 'cmsHeadline';
    protected const CMS_DESCRIPTION_FIELD = 'cmsDescription';

    public function __construct()
    {
        parent::__construct('category');

        $this->primaryKeyFields[self::UUID_FIELD] = (new UuidField('uuid'))->setFlags(new Required());
        $this->fields[self::PATH_FIELD] = new LongTextField('path');
        $this->fields[self::POSITION_FIELD] = new IntField('position');
        $this->fields[self::LEVEL_FIELD] = new IntField('level');
        $this->fields[self::TEMPLATE_FIELD] = new StringField('template');
        $this->fields[self::ACTIVE_FIELD] = new BoolField('active');
        $this->fields[self::IS_BLOG_FIELD] = new BoolField('is_blog');
        $this->fields[self::EXTERNAL_FIELD] = new StringField('external');
        $this->fields[self::HIDE_FILTER_FIELD] = new BoolField('hide_filter');
        $this->fields[self::HIDE_TOP_FIELD] = new BoolField('hide_top');
        $this->fields[self::PRODUCT_BOX_LAYOUT_FIELD] = new StringField('product_box_layout');
        $this->fields[self::PRODUCT_STREAM_UUID_FIELD] = new StringField('product_stream_uuid');
        $this->fields[self::HIDE_SORTINGS_FIELD] = new BoolField('hide_sortings');
        $this->fields[self::SORTING_UUIDS_FIELD] = new LongTextField('sorting_uuids');
        $this->fields[self::FACET_UUIDS_FIELD] = new LongTextField('facet_uuids');
        $this->fields['blogs'] = new SubresourceField(\Shopware\Framework\Write\Resource\BlogWriteResource::class);
        $this->fields['parent'] = new ReferenceField('parentUuid', 'uuid', \Shopware\Category\Writer\Resource\CategoryWriteResource::class);
        $this->fields['parentUuid'] = (new FkField('parent_uuid', \Shopware\Category\Writer\Resource\CategoryWriteResource::class, 'uuid'));
        $this->fields['media'] = new ReferenceField('mediaUuid', 'uuid', \Shopware\Media\Writer\Resource\MediaWriteResource::class);
        $this->fields['mediaUuid'] = (new FkField('media_uuid', \Shopware\Media\Writer\Resource\MediaWriteResource::class, 'uuid'));
        $this->fields[self::NAME_FIELD] = new TranslatedField('name', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::PATH_NAMES_FIELD] = new TranslatedField('pathNames', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::META_KEYWORDS_FIELD] = new TranslatedField('metaKeywords', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::META_TITLE_FIELD] = new TranslatedField('metaTitle', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::META_DESCRIPTION_FIELD] = new TranslatedField('metaDescription', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::CMS_HEADLINE_FIELD] = new TranslatedField('cmsHeadline', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields[self::CMS_DESCRIPTION_FIELD] = new TranslatedField('cmsDescription', \Shopware\Shop\Writer\Resource\ShopWriteResource::class, 'uuid');
        $this->fields['translations'] = (new SubresourceField(\Shopware\Category\Writer\Resource\CategoryTranslationWriteResource::class, 'languageUuid'))->setFlags(new Required());
        $this->fields['parent'] = new SubresourceField(\Shopware\Category\Writer\Resource\CategoryWriteResource::class);
        $this->fields['avoidCustomerGroups'] = new SubresourceField(\Shopware\Category\Writer\Resource\CategoryAvoidCustomerGroupWriteResource::class);
        $this->fields['productCategories'] = new SubresourceField(\Shopware\Product\Writer\Resource\ProductCategoryWriteResource::class);
        $this->fields['productCategorySeos'] = new SubresourceField(\Shopware\Product\Writer\Resource\ProductCategorySeoWriteResource::class);
        $this->fields['shippingMethodCategories'] = new SubresourceField(\Shopware\ShippingMethod\Writer\Resource\ShippingMethodCategoryWriteResource::class);
        $this->fields['shops'] = new SubresourceField(\Shopware\Shop\Writer\Resource\ShopWriteResource::class);
    }

    public function getWriteOrder(): array
    {
        return [
            \Shopware\Framework\Write\Resource\BlogWriteResource::class,
            \Shopware\Category\Writer\Resource\CategoryWriteResource::class,
            \Shopware\Media\Writer\Resource\MediaWriteResource::class,
            \Shopware\Category\Writer\Resource\CategoryTranslationWriteResource::class,
            \Shopware\Category\Writer\Resource\CategoryAvoidCustomerGroupWriteResource::class,
            \Shopware\Product\Writer\Resource\ProductCategoryWriteResource::class,
            \Shopware\Product\Writer\Resource\ProductCategorySeoWriteResource::class,
            \Shopware\ShippingMethod\Writer\Resource\ShippingMethodCategoryWriteResource::class,
            \Shopware\Shop\Writer\Resource\ShopWriteResource::class,
        ];
    }

    public static function createWrittenEvent(array $updates, TranslationContext $context, array $errors = []): \Shopware\Category\Event\CategoryWrittenEvent
    {
        $event = new \Shopware\Category\Event\CategoryWrittenEvent($updates[self::class] ?? [], $context, $errors);

        unset($updates[self::class]);

        if (!empty($updates[\Shopware\Framework\Write\Resource\BlogWriteResource::class])) {
            $event->addEvent(\Shopware\Framework\Write\Resource\BlogWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Category\Writer\Resource\CategoryWriteResource::class])) {
            $event->addEvent(\Shopware\Category\Writer\Resource\CategoryWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Media\Writer\Resource\MediaWriteResource::class])) {
            $event->addEvent(\Shopware\Media\Writer\Resource\MediaWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Category\Writer\Resource\CategoryTranslationWriteResource::class])) {
            $event->addEvent(\Shopware\Category\Writer\Resource\CategoryTranslationWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Category\Writer\Resource\CategoryAvoidCustomerGroupWriteResource::class])) {
            $event->addEvent(\Shopware\Category\Writer\Resource\CategoryAvoidCustomerGroupWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Product\Writer\Resource\ProductCategoryWriteResource::class])) {
            $event->addEvent(\Shopware\Product\Writer\Resource\ProductCategoryWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Product\Writer\Resource\ProductCategorySeoWriteResource::class])) {
            $event->addEvent(\Shopware\Product\Writer\Resource\ProductCategorySeoWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\ShippingMethod\Writer\Resource\ShippingMethodCategoryWriteResource::class])) {
            $event->addEvent(\Shopware\ShippingMethod\Writer\Resource\ShippingMethodCategoryWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[\Shopware\Shop\Writer\Resource\ShopWriteResource::class])) {
            $event->addEvent(\Shopware\Shop\Writer\Resource\ShopWriteResource::createWrittenEvent($updates, $context));
        }

        return $event;
    }
}