<?php

/**
 * @file
 * This file contains the common functions for
 * testing service callable factories.
 */

namespace {

    use AwdStudio\Tests\DI\Module\Services\DummyService;
    use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgumentFroCallable;
    use AwdStudio\Tests\DI\Module\Services\DummyServiceWithNameForCallable;


    /**
     * A factory to create the service instance.
     *
     * @return \AwdStudio\Tests\DI\Module\Services\DummyServiceWithNameForCallable
     */
    function dummyFunctionFactory(): DummyServiceWithNameForCallable
    {
        return new DummyServiceWithNameForCallable();
    }


    /**
     * A factory to create the service instance that needs an argument.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyService $dummyService
     *
     * @return \AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgumentFroCallable
     */
    function dummyFunctionFactoryWithArguments(DummyService $dummyService): DummyServiceWithArgumentFroCallable
    {
        return new DummyServiceWithArgumentFroCallable($dummyService);
    }

}


namespace AwdStudio\Tests\DI\Module\Services {

    /**
     * A factory to create the service instance.
     *
     * @return \AwdStudio\Tests\DI\Module\Services\DummyServiceWithNameForCallable
     */
    function dummyFunctionFactory(): DummyServiceWithNameForCallable
    {
        return new DummyServiceWithNameForCallable();
    }


    /**
     * A factory to create the service instance that needs an argument.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyService $dummyService
     *
     * @return \AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgumentFroCallable
     */
    function dummyFunctionFactoryWithArguments(DummyService $dummyService): DummyServiceWithArgumentFroCallable
    {
        return new DummyServiceWithArgumentFroCallable($dummyService);
    }

}
