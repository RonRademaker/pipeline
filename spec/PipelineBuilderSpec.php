<?php

namespace spec\League\Pipeline;

use League\Pipeline\CallableStage;
use PhpSpec\ObjectBehavior;

class PipelineBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Pipeline\PipelineBuilder');
    }

    function it_should_build_a_pipeline()
    {
        $this->build()->shouldHaveType('League\Pipeline\PipelineInterface');
    }

    function it_should_collect_operations_for_a_pipeline()
    {
        $this->add(CallableStage::forCallable(function ($p) {
            return $p * 2;
        }));

        $this->build()->process(4)->shouldBe(8);
    }

    function it_should_have_a_fluent_build_interface()
    {
        $operation = CallableStage::forCallable(function () {});
        $this->add($operation)->shouldBe($this);
    }
}
