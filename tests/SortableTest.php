<?php

class SortableTest extends TestBase {

    protected function getSortable($attributes = ['title' => 'Foo'])
    {
        return SortableItem::create($attributes);
    }

    /** @test */
    function it_throws_exception_when_sortable_columns_are_not_defined()
    {
        try {
            InvalidItem::create(['title' => 'foo']);

        } catch(RuntimeException $e)
        {
            if($e->getMessage() === 'The sortableColumns property is not set.')
            {
                return;
            }
        }

        return $this->fail('Expected RuntimeException not thrown.');
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
        $sortable = $this->getSortable(['title' => 'Foo']);

        $this->assertEquals(
            $sortable->getSortableKey('non_existing_sorting_key'),
            'id'
        );
    }

    /** @test */
    function it_returns_sortable_column_with_key()
    {
        $sortable = $this->getSortable(['title' => 'Foo']);

        $this->assertEquals(
            $sortable->getSortableKey('date'),
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
        $sortable = $this->getSortable(['title' => 'Foo']);

        $this->assertEquals(
            $sortable->getSortableDirection('non_existing_sorting_direction'),
            'asc'
        );
    }

    /** @test */
    function it_returns_sortable_column_with_direction()
    {
        $sortable = $this->getSortable(['title' => 'Foo']);

        $this->assertEquals(
            $sortable->getSortableDirection('DeSc'),
            'desc'
        );
    }

}