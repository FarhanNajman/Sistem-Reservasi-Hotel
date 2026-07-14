@extends('layouts.admin')

@section('content')
<div class="admin-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="admin-title" style="margin: 0;">Statistik Hunian</h1>
    <a href="{{ route('admin.statistik.pdf') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background-color: #10b981; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: 0.3s; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
        <i data-lucide="printer" style="width: 18px; height: 18px;"></i> Cetak Laporan PDF
    </a>
</div>

<div style="background-color: #1e1e2d; border-radius: 12px; padding: 25px; margin-top: 20px;">
    <h3 style="color: #fff; margin-top: 0; margin-bottom: 20px; font-weight: 500;">Grafik Rasio Hunian Bulanan</h3>
    
    @if(count($data) > 0)
        <div style="position: relative; height: 60vh; width: 100%;">
            <canvas id="occupancyChart"></canvas>
        </div>
    @else
        <div style="padding: 40px; text-align: center; color: #a2a3b7; background-color: #1b1b29; border-radius: 8px;">
            <i data-lucide="bar-chart-2" style="width: 48px; height: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
            <p>Belum ada data reservasi yang valid untuk ditampilkan.</p>
        </div>
    @endif
</div>

<!-- Import Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('occupancyChart');
        
        if (ctx) {
            const labels = @json($labels);
            const data = @json($data);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Kamar Terpesan',
                        data: data,
                        backgroundColor: 'rgba(212, 175, 55, 0.15)', // Soft Gold color for fill
                        borderColor: 'rgba(212, 175, 55, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#1e1e2d',
                        pointBorderColor: 'rgba(212, 175, 55, 1)',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4 // Smooth curve
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#a2a3b7',
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 13
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 26, 39, 0.9)',
                            titleColor: '#d4af37',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#a2a3b7',
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(162, 163, 183, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#a2a3b7'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
