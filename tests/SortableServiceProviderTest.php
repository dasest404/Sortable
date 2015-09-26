<?php

class SortableServiceProviderTest extends TestBase {

    /** @test */
    function it_registers_the_supporter()
    {
        $this->assertInstanceOf(
            'Kenarkose\Sortable\Supporter',
            $this->app['sortable.supporter']
        );
    }

    /** @test */
    function it_registers_helpers()
    {
        $this->assertTrue(
            function_exists('sortable_link')
        );

        $this->assertTrue(
            function_exists('qs_url')
        );
    }

}