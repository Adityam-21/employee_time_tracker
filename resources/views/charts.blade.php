<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="border-b border-gray-200 pb-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee Time Contribution Analysis</h1>
            <p class="text-gray-600">Comprehensive overview of employee working hours across different visualization
                formats</p>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800 mb-1">Total Employees</h3>
                <p class="text-2xl font-bold text-blue-900" id="totalEmployees">-</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <h3 class="text-sm font-medium text-green-800 mb-1">Total Hours</h3>
                <p class="text-2xl font-bold text-green-900" id="totalHours">-</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <h3 class="text-sm font-medium text-purple-800 mb-1">Average Hours</h3>
                <p class="text-2xl font-bold text-purple-900" id="avgHours">-</p>
            </div>
        </div>

        {{-- Charts Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Bar Chart --}}
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Hours Distribution</h3>
                    <span class="text-sm text-gray-500 bg-white px-2 py-1 rounded">Bar Chart</span>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="barChart"></canvas>
                </div>
                <p class="text-sm text-gray-600 mt-3">Compare individual employee contributions at a glance</p>
            </div>

            {{-- Line Chart --}}
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Trend Analysis</h3>
                    <span class="text-sm text-gray-500 bg-white px-2 py-1 rounded">Line Chart</span>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="lineChart"></canvas>
                </div>
                <p class="text-sm text-gray-600 mt-3">Visualize patterns and trends in work hour distribution</p>
            </div>
        </div>

        {{-- Pie Chart - Full Width --}}
        <div class="mt-8">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Proportional Contribution</h3>
                    <span class="text-sm text-gray-500 bg-white px-2 py-1 rounded">Pie Chart</span>
                </div>
                <div class="flex justify-center">
                    <div class="relative" style="width: 400px; height: 400px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-3 text-center">View each employee's percentage contribution to total
                    hours</p>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="mt-8">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detailed Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Employee</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Hours</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Percentage</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable" class="divide-y divide-gray-200">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample data - replace with your actual Laravel data
    const labels = {!! json_encode($employeeHours->pluck('name')) !!};
    const data = {!! json_encode($employeeHours->pluck('hours')) !!};

    // Calculate summary statistics
    const totalEmployees = labels.length;
    const totalHours = data.reduce((sum, hours) => sum + hours, 0);
    const avgHours = (totalHours / totalEmployees).toFixed(1);

    // Update summary stats
    document.getElementById('totalEmployees').textContent = totalEmployees;
    document.getElementById('totalHours').textContent = totalHours;
    document.getElementById('avgHours').textContent = avgHours;

    // Chart.js default configuration
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#374151';

    // Color palette
    const colors = [
        '#3B82F6', '#EF4444', '#10B981', '#F59E0B',
        '#8B5CF6', '#F97316', '#06B6D4', '#84CC16'
    ];

    // Bar Chart
    new Chart(document.getElementById('barChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Total Hours',
                data,
                backgroundColor: colors[0] + '20',
                borderColor: colors[0],
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 6,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} hours (${((context.parsed.y / totalHours) * 100).toFixed(1)}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + 'h';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Line Chart
    new Chart(document.getElementById('lineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Total Hours',
                data,
                fill: true,
                backgroundColor: colors[1] + '10',
                borderColor: colors[1],
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: colors[1],
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 6,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} hours`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + 'h';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                label: 'Hours',
                data,
                backgroundColor: colors.slice(0, labels.length),
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 6,
                    callbacks: {
                        label: function(context) {
                            const percentage = ((context.parsed / totalHours) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} hours (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '50%'
        }
    });

    // Populate data table
    function populateTable() {
        const tableBody = document.getElementById('dataTable');
        tableBody.innerHTML = '';

        // Create array of employee data with percentages
        const employeeData = labels.map((name, index) => ({
            name,
            hours: data[index],
            percentage: ((data[index] / totalHours) * 100).toFixed(1)
        }));

        // Sort by hours (descending)
        employeeData.sort((a, b) => b.hours - a.hours);

        employeeData.forEach((employee, index) => {
            const row = document.createElement('tr');
            row.className = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';

            // Determine status based on hours
            let status, statusClass;
            if (employee.hours >= avgHours * 1.2) {
                status = 'High Contributor';
                statusClass = 'bg-green-100 text-green-800';
            } else if (employee.hours >= avgHours * 0.8) {
                status = 'Average';
                statusClass = 'bg-blue-100 text-blue-800';
            } else {
                status = 'Below Average';
                statusClass = 'bg-yellow-100 text-yellow-800';
            }

            row.innerHTML = `
                <td class="px-4 py-3 text-sm font-medium text-gray-900">${employee.name}</td>
                <td class="px-4 py-3 text-sm text-gray-700">${employee.hours} hours</td>
                <td class="px-4 py-3 text-sm text-gray-700">${employee.percentage}%</td>
                <td class="px-4 py-3">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${statusClass}">
                        ${status}
                    </span>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    // Initialize table
    populateTable();
</script>
