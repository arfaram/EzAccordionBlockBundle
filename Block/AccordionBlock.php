<?php
/**
 *
 */

namespace EzAccordionBlockBundle\Block;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\SearchService;
use EzAccordionBlockBundle\Exception\InvalidBlockAttributeException;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;

/**
 * AccordionBlock block
 * Displays list of content from given root.
 */
class AccordionBlock extends AbstractBlockType implements BlockType
{
    /**
     * ContentType regular expression pattern matching single ContentType
     * name or comma separated list of ContentTypes.
     *
     * @example article,place,blog_post
     * @example article
     *
     * @var string
     */
    const PATTERN_CONTENT_TYPE = '/^([a-zA-Z_-]+|,[a-zA-Z_-]+)+$/i';

    /**
     * ContentType ID regular expression.
     *
     * @example 16
     *
     * @var string
     */
    const PATTERN_CONTENT_ID = '/[0-9]+/';

    /** @var LocationService */
    private $locationService;

    /** @var ContentService */
    private $contentService;

    /** @var SearchService */
    private $searchService;

    /**
     * @param LocationService     $locationService
     * @param ContentService      $contentService
     * @param SearchService       $searchService
     */
    public function __construct(
        LocationService $locationService,
        ContentService $contentService,
        SearchService $searchService
    ) {
        $this->locationService = $locationService;
        $this->contentService = $contentService;
        $this->searchService = $searchService;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateParameters(BlockValue $blockValue)
    {
        $attributes = $blockValue->getAttributes();
        $contentInfo = $this->contentService->loadContentInfo($attributes['parentContentId']);

        $query = new Query();
        $query->query = new Criterion\LogicalAnd(
            [
                new Criterion\ParentLocationId($contentInfo->mainLocationId),
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ContentTypeIdentifier( array( 'accordion' ) ),
            ]
        );


        $searchHits = $this->searchService->findContent($query)->searchHits;


        $contentArray = [];
        foreach ($searchHits as $key => $searchHit) {
            $content = $searchHit->valueObject;
            $contentArray[$key]['content'] = $content;
        }

        return [
            'contentArray' => $contentArray,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'accordion',
            'Accordion List',
            'default',
            'bundles/ezaccordionblock/images/thumbnails/accordion.svg',
            [],
            [
                new BlockAttributeDefinition(
                    'parentContentId',
                    'Parent',
                    'embed',
                    self::PATTERN_CONTENT_ID,
                    'Choose an accordion folder'
                ),


            ]
        );
    }



    /**
     * {@inheritdoc}
     */
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['parentContentId']) || preg_match(self::PATTERN_CONTENT_ID, $attributes['parentContentId']) !== 1) {
            throw new InvalidBlockAttributeException('Parent container', 'parentContentId', 'Parent ContentId must be defined.');
        }

    }
}
