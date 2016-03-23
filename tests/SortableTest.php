<?php

class SortableTest extends TestBase {

    protected function getSortable($attributes = ['title' => 'Foo'])
    {
        return SortableItem::create($attributes);
    }

    protected function getSupporter()
    {
        return $this->app['sortable.supporter'];
    }

    /** @test */
    function it_throws_exception_when_sortable_columns_are_not_defined()
    {
        try
        {
            InvalidItem::create(['title' => 'foo']);

        } catch (RuntimeException $e)
        {
            if ($e->getMessage() === 'The sortableColumns property is not set.')
            {
                return;
            }
        }

        return $this->fail('Expected RuntimeException not thrown.');
    }

    /** @test */
    function it_registers_supplied_params_to_supporter()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        SortableItem::sortable('title', 'desc');

        $this->assertEquals(
            'title',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'desc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_registers_defaults_to_supporter()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        // At this point the request does not have any params so
        // even if scope would try to pull it from scope it will
        // still be null and fallback to defaults
        SortableItem::sortable();

        $this->assertEquals(
            'id',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'asc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_selectively_fallsback_to_default_params()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        SortableItem::sortable('title');

        $this->assertEquals(
            'title',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'asc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_fallsback_to_default_params_when_invalid_params_supplied()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        SortableItem::sortable('non_existing_key', 'non_existing_direction');

        $this->assertEquals(
            'id',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'asc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_registers_request_params()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        // Populate request
        \Request::replace(
            array_merge(
                \Request::input(),
                [
                    's' => 'created_at',
                    'd' => 'desc'
                ]
            )
        );

        $this->assertEquals(
            'created_at',
            Request::input('s')
        );

        $this->assertEquals(
            'desc',
            Request::input('d')
        );

        SortableItem::sortable();

        $this->assertEquals(
            'created_at',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'desc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_returns_default_key()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableKey(),
            'id'
        );
    }

    /** @test */
    function it_returns_defined_sortable_key()
    {
        $sortable = KeyItem::create(['title' => 'foo']);

        $this->assertEquals(
            $sortable->getSortableKey(),
            'title'
        );
    }

    /** @test */
    function it_returns_default_sortable_if_key_is_invalid()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableKey('non_existing_sorting_key'),
            'id'
        );
    }

    /** @test */
    function it_returns_sortable_column_with_key()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableKey('created_at'),
            'created_at'
        );
    }

    /** @test */
    function it_returns_default_direction()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableDirection(),
            'asc'
        );
    }

    /** @test */
    function it_returns_defined_sortable_direction()
    {
        $sortable = DirectionItem::create(['title' => 'foo']);

        $this->assertEquals(
            $sortable->getSortableDirection(),
            'desc'
        );
    }

    /** @test */
    function it_returns_default_sortable_if_direction_is_invalid()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableDirection('non_existing_sorting_direction'),
            'asc'
        );
    }

    /** @test */
    function it_returns_sortable_column_with_direction()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            $sortable->getSortableDirection('DeSc'),
            'desc'
        );
    }

    /** @test */
    function it_gets_special_sortable_keys()
    {
        $sortable = $this->getSortable();

        $this->assertEquals(
            ['special_key' => 'specialFunction'],
            $sortable->getSpecialSortableKeys()
        );

        $sortable = DirectionItem::create(['title' => 'foo']);

        $this->assertEquals(
            [],
            $sortable->getSpecialSortableKeys()
        );
    }

    /** @test */
    function it_calls_special_sortable_function()
    {
        try
        {
            SortableItem::sortable('special_key', 'asc');
        } catch (\Exception $e)
        {
            if ($e->getMessage() === 'special_key')
            {
                return;
            }
        }

        $this->fail('Special function not called, test fails.');
    }

}