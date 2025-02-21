<?php

use function Livewire\Volt\{computed, state};
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

state(food: 0, shopping: 0, travel: 0);

$incrementFood = fn () => $this->food++;
$incrementShopping = fn () => $this->shopping++;
$incrementTravel = fn () => $this->travel++;

$expenses = computed(fn () => (new PieChartModel())
    ->setTitle('Expenses by Type')
    ->addSlice('Food', $this->food, '#f6ad55')
    ->addSlice('Shopping', $this->shopping, '#fc8181')
    ->addSlice('Travel', $this->travel, '#90cdf4'));

?>

<div
    style="width: 100%; height: 100%;"
    x-data="{ ...livewireChartsColumnChart() }"
    x-init="init()"
>
    <div wire:ignore x-ref="container"></div>
</div>