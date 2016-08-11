<?php

class SupporterTest extends TestBase {

    protected function getSupporter()
    {
        return $this->app['sortable.supporter'];
    }

    /** @test */
    function it_sets_and_gets_params()
    {
        $supporter = $this->getSupporter();

        $this->assertNull(
            $supporter->getCurrentDirection()
        );

        $this->assertNull(
            $supporter->getCurrentKey()
        );

        $supporter->setParams('derp', 'asc');

        $this->assertEquals(
            'derp',
            $supporter->getCurrentKey()
        );

        $this->assertEquals(
            'asc',
            $supporter->getCurrentDirection()
        );
    }

    /** @test */
    function it_gets_the_current_path()
    {
        $supporter = $this->getSupporter();

        $this->assertEquals(
            '/',
            $supporter->getCurrentRequestPath()
        );
    }

    /** @test */
    function it_generates_sortable_links()
    {
        // Let's initiate the sortable supporter
        SortableItem::sortable('title', 'desc');

        $supporter = $this->getSupporter();

        $this->assertEquals(
            '<a title="Title" class="sortable-link sortable-link--asc " href="http://localhost?s=id&d=asc">Text</a>',
            $supporter->generateLinkFor('id', 'Text', 'Title')
        );
    }

    /** @test */
    function it_generates_sortable_active_links()
    {
        SortableItem::sortable();

        $supporter = $this->getSupporter();

        $this->assertEquals(
            '<a title="Title" class="sortable-link sortable-link--asc sortable-link--active" href="http://localhost?s=id&d=desc">Text</a>',
            $supporter->generateLinkFor('id', 'Text', 'Title')
        );
    }

}