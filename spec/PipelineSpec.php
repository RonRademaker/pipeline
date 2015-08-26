<?php

namespace spec\League\Pipeline;

use League\Pipeline\CallableStage;
use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;

class PipelineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Pipeline\Pipeline');
        $this->shouldHaveType('League\Pipeline\PipelineInterface');
    }

    function it_should_pipe_operation()
    {
        $operation = CallableStage::forCallable(function () {});
        $this->pipe($operation)->shouldHaveType('League\Pipeline\PipelineInterface');
        $this->pipe($operation)->shouldNotBe($this);
    }

    function it_should_compose_pipelines()
    {
        $pipeline = new Pipeline();
        $this->pipe($pipeline)->shouldHaveType('League\Pipeline\PipelineInterface');
        $this->pipe($pipeline)->shouldNotBe($this);
    }

    function it_should_process_a_payload()
    {
        $operation = CallableStage::forCallable(function ($payload) { return $payload + 1; });
        $this->pipe($operation)->process(1)->shouldBe(2);
    }

    function it_should_execute_operations_sequential()
    {
        $this->beConstructedWith([
            CallableStage::forCallable(function ($p) { return $p + 2; }),
            CallableStage::forCallable(function ($p) { return $p * 10; }),
        ]);

        $this->process(1)->shouldBe(30);
    }

    function it_should_only_allow_operations_as_constructor_arguments()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', [['fooBar']]);
    }
}
