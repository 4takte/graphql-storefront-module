<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Storefront\Tests\Integration\Controller;

use DateTimeImmutable;
use OxidEsales\GraphQL\Base\Tests\Integration\TokenTestCase;
use TheCodingMachine\GraphQLite\Types\DateTimeType;

final class ManufacturerWithTokenTest extends TokenTestCase
{
    //Kuyichi
    private const ACTIVE_MANUFACTURER = '9434afb379a46d6c141de9c9e5b94fcf';

    //RRD
    private const INACTIVE_MANUFACTURER  = 'adca51c88a3caa1c7b939fd6a229ae3a';

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepareToken();
    }

    public function testGetSingleActiveManufacturer(): void
    {
        $result = $this->query('query {
            manufacturer (manufacturerId: "' . self::ACTIVE_MANUFACTURER . '") {
                id
                active
                icon
                title
                shortdesc
                timestamp
                seo {
                  url
                }
            }
        }');

        $manufacturer = $result['body']['data']['manufacturer'];

        $this->assertSame(self::ACTIVE_MANUFACTURER, $manufacturer['id']);
        $this->assertSame(true, $manufacturer['active']);
        $this->assertMatchesRegularExpression('@https?://.*logo3_ico.png$@', $manufacturer['icon']);
        $this->assertSame('Kuyichi', $manufacturer['title']);
        $this->assertSame('Eine stilbewusste Marke', $manufacturer['shortdesc']);
        $this->assertMatchesRegularExpression('@https?://.*Nach-Hersteller/Kuyichi/$@', $manufacturer['seo']['url']);

        $dateTimeType = new DateTimeType();
        //Fixture timestamp can have few seconds difference
        $this->assertLessThanOrEqual(
            $dateTimeType->serialize(new DateTimeImmutable('now')),
            $result['body']['data']['manufacturer']['timestamp']
        );

        $this->assertEmpty(array_diff(array_keys($manufacturer), [
            'id',
            'active',
            'icon',
            'title',
            'shortdesc',
            'timestamp',
            'seo',
        ]));
    }

    public function testGetSingleInactiveManufacturer(): void
    {
        $result = $this->query('query {
            manufacturer (manufacturerId: "' . self::INACTIVE_MANUFACTURER . '") {
                id
            }
        }');

        $this->assertEquals(
            [
                'id' => self::INACTIVE_MANUFACTURER,
            ],
            $result['body']['data']['manufacturer']
        );
    }

    public function testGetSingleNonExistingManufacturer(): void
    {
        $result = $this->query('query {
            manufacturer (manufacturerId: "DOES-NOT-EXIST") {
                id
            }
        }');

        $this->assertSame(
            'Manufacturer was not found by id: DOES-NOT-EXIST',
            $result['body']['errors'][0]['message']
        );
    }

    public function testGetManufacturerListWithoutFilter(): void
    {
        $result = $this->query('query {
            manufacturers {
                id
            }
        }');

        // fixtures have total 15 manufacturers, 4 inactive and 11 active
        $this->assertEquals(
            15,
            count($result['body']['data']['manufacturers'])
        );
    }

    public function testGetManufacturerListWithPartialFilter(): void
    {
        $result = $this->query('query {
            manufacturers(filter: {
                title: {
                    beginsWith: "Fly"
                }
            }) {
                id
            }
        }');

        $this->assertEquals(
            [
                [
                    'id' => 'dc50589ad69b6ec71721b25bdd403171',
                ],
                [
                    'id' => 'dc59459d4d67189182c53ed0e4e777bc',
                ],
            ],
            $result['body']['data']['manufacturers']
        );
    }

    public function testGetEmptyManufacturerListWithExactMatchFilter(): void
    {
        $result = $this->query('query {
            manufacturers(filter: {
                title: {
                    equals: "Flysurfer"
                }
            }) {
                id
            }
        }');

        $this->assertEquals(
            [
                [
                    'id' => 'dc50589ad69b6ec71721b25bdd403171',
                ],
            ],
            $result['body']['data']['manufacturers']
        );
    }
}
