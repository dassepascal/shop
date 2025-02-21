<?php

namespace App\Folios;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class OrderChart extends Component
{
    public $chartModel;

    public function mount()
    {
        $this->chartModel = $this->generateChartData();
    }

    public function generateChartData()
    {
        $months = collect(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $orders = collect([30, 45, 29, 56, 40, 60, 75, 50, 65, 70, 80, 90]);

        $chartModel = new ColumnChartModel();
        foreach ($months as $index => $month) {
            $chartModel->addColumn($month, $orders[$index], '#f6ad55');
        }

        return $chartModel;
    }

    public function render()
    {
        return view('livewire.orderchart', [
            'chartModel' => $this->chartModel,
        ]);
    }
}
?>
<div>
    <livewire:livewire-column-chart :column-chart-model="$chartModel" />
    @livewireChartsScripts
</div>