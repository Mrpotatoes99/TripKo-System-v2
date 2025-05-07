<?php
require_once('../../tripko-backend/config/check_session.php');
checkAdminSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TripKo Pangasinan - Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../file_css/dashboard.css" />
  <style>
    canvas#transportChart {
      width: 100% !important;
      height: 100% !important;
      position: absolute !important;
      top: 0;
      left: 0;
    }
  </style>
</head>
<body class="bg-white text-gray-900">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="flex flex-col w-72 bg-gradient-to-b from-[#1d4ed8] to-[#1e40af] text-white">
      <!-- Logo and Brand -->
      <div class="p-6 border-b border-blue-700">
        <div class="flex items-center space-x-4">
          <div class="p-2 bg-white bg-opacity-10 rounded-lg">
            <i class="fas fa-compass text-3xl"></i>
          </div>
          <div>
            <h1 class="text-2xl font-bold">TripKo</h1>
            <p class="text-sm text-blue-200">Pangasinan Tourism</p>
          </div>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="dashboard.php" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
          <i class="fas fa-home w-6"></i>
          <span class="ml-3">Dashboard</span>
        </a>

        <!-- Tourism Section -->
        <div class="mt-6">
          <p class="px-4 text-xs font-semibold text-blue-300 uppercase">Tourism</p>
          <div class="mt-3 space-y-2">
            <a href="tourist_spot.php" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
              <i class="fas fa-umbrella-beach w-6"></i>
              <span class="ml-3">Tourist Spots</span>
            </a>
            <a href="itineraries.html" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
              <i class="fas fa-map-marked-alt w-6"></i>
              <span class="ml-3">Itineraries</span>
            </a>
            <a href="festival.html" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
              <i class="fas fa-calendar-alt w-6"></i>
              <span class="ml-3">Festivals</span>
            </a>
          </div>
        </div>

        <!-- Transportation Section -->
        <div class="mt-6">
          <p class="px-4 text-xs font-semibold text-blue-300 uppercase">Transportation</p>
          <div class="mt-3 space-y-2">
            <button onclick="toggleTransportDropdown(event)" class="w-full flex items-center justify-between px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
              <div class="flex items-center">
                <i class="fas fa-bus w-6"></i>
                <span class="ml-3">Transport Info</span>
              </div>
              <i class="fas fa-chevron-down text-sm transition-transform duration-200" id="transportDropdownIcon"></i>
            </button>
            <div id="transportDropdown" class="hidden pl-4 space-y-2">
              <a href="terminal-locations.html" class="flex items-center px-4 py-2 text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg transition-colors group">
                <i class="fas fa-map-marker-alt w-6"></i>
                <span class="ml-3">Terminals</span>
              </a>
              <a href="terminal-routes.html" class="flex items-center px-4 py-2 text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg transition-colors group">
                <i class="fas fa-route w-6"></i>
                <span class="ml-3">Routes & Types</span>
              </a>
              <a href="fare.html" class="flex items-center px-4 py-2 text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg transition-colors group">
                <i class="fas fa-money-bill-wave w-6"></i>
                <span class="ml-3">Fare Rates</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Management Section -->
        <div class="mt-6">
          <p class="px-4 text-xs font-semibold text-blue-300 uppercase">Management</p>
          <div class="mt-3 space-y-2">
            <a href="users.php" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
              <i class="fas fa-users w-6"></i>
              <span class="ml-3">Users</span>
            </a>
            <a href="reports.php" class="flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg transition-colors group">
              <i class="fas fa-chart-bar w-6"></i>
              <span class="ml-3">Reports</span>
            </a>
          </div>
        </div>
      </nav>

      <!-- User Profile -->
      <div class="p-6 border-t border-blue-700">
        <div class="flex items-center space-x-4">
          <div class="p-2 bg-white bg-opacity-10 rounded-full">
            <i class="fas fa-user-circle text-2xl"></i>
          </div>
          <div>
            <h3 class="font-medium">Administrator</h3>
            <a href="../../tripko-backend/config/confirm_logout.php" class="text-sm text-blue-200 hover:text-white group flex items-center mt-1">
              <i class="fas fa-sign-out-alt mr-2"></i>
              <span>Sign Out</span>
            </a>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 bg-[#F3F1E7] p-6">
      <header class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3 text-gray-900 font-normal text-base">
          <button aria-label="Menu" class="focus:outline-none">
            <i class="fas fa-bars text-lg"></i>
          </button>
          <span>Reports</span>
        </div>
        <div class="flex items-center gap-4">
          <div>
            <select id="reportPeriod" class="rounded-full border border-gray-400 bg-[#F3F1E7] py-1.5 px-4 text-gray-600">
              <option value="7">Last 7 days</option>
              <option value="30">Last 30 days</option>
              <option value="90">Last 3 months</option>
              <option value="365">Last year</option>
            </select>
          </div>
          <button aria-label="Notifications" class="text-black text-xl focus:outline-none">
            <i class="fas fa-bell"></i>
          </button>
        </div>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tourism Statistics -->
        <div class="bg-white p-6 rounded-lg shadow-md transform transition-all duration-300 hover:shadow-xl">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-[#255D8A]">Tourism Statistics</h3>
            <div class="bg-[#255D8A] text-white px-3 py-1 rounded-full text-sm">
              Last <span id="periodDisplay">30</span> days
            </div>
          </div>
          <div class="h-64">
            <canvas id="tourismChart"></canvas>
          </div>
          <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="bg-[#F3F1E7] p-4 rounded-lg transition-all duration-300 hover:bg-[#E9E6DC]">
              <p class="text-sm text-[#255D8A] mb-1">Most Popular Spot</p>
              <p class="font-semibold text-lg" id="popularSpot">Loading...</p>
              <p class="text-xs text-gray-500 mt-1" id="popularSpotLocation"></p>
            </div>
            <div class="bg-[#F3F1E7] p-4 rounded-lg transition-all duration-300 hover:bg-[#E9E6DC]">
              <p class="text-sm text-[#255D8A] mb-1">Total Visitors</p>
              <p class="font-semibold text-lg" id="totalVisitors">Loading...</p>
              <p class="text-xs text-gray-500 mt-1" id="visitorsTrend"></p>
            </div>
          </div>
        </div>

        <!-- Transportation Analytics -->
        <div class="bg-white p-6 rounded-lg shadow-md transform transition-all duration-300 hover:shadow-xl">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-[#255D8A]">Transportation Analytics</h3>
            <div class="text-sm text-gray-500">
              <i class="fas fa-chart-pie mr-1"></i> Distribution
            </div>
          </div>
          <div class="h-64">
            <canvas id="transportChart"></canvas>
          </div>
          <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="bg-[#F3F1E7] p-4 rounded-lg transition-all duration-300 hover:bg-[#E9E6DC]">
              <p class="text-sm text-[#255D8A] mb-1">Popular Route</p>
              <p class="font-semibold text-lg" id="popularRoute">Loading...</p>
              <p class="text-xs text-gray-500 mt-1" id="routeDetails"></p>
            </div>
            <div class="bg-[#F3F1E7] p-4 rounded-lg transition-all duration-300 hover:bg-[#E9E6DC]">
              <p class="text-sm text-[#255D8A] mb-1">Most Used Transport</p>
              <p class="font-semibold text-lg" id="popularTransport">Loading...</p>
              <p class="text-xs text-gray-500 mt-1" id="transportPercent"></p>
            </div>
          </div>
        </div>

        <!-- User Activity -->
        <div class="col-span-2 bg-white p-6 rounded-lg shadow-md transform transition-all duration-300 hover:shadow-xl relative overflow-hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-[#255D8A]">User Activity</h3>
            <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
              Coming Soon
            </div>
          </div>
          <div class="relative">
            <div class="absolute inset-0 bg-gray-50 bg-opacity-90 backdrop-blur-sm flex items-center justify-center z-10">
              <div class="text-center">
                <i class="fas fa-user-clock text-4xl text-[#255D8A] mb-3"></i>
                <p class="text-gray-600 mb-2">User activity tracking is under development</p>
                <p class="text-sm text-gray-500">This feature will be available in the next update</p>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div class="bg-[#F3F1E7] p-4 rounded-lg">
                  <h4 class="text-sm font-medium text-[#255D8A] mb-3">Active Users Overview</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">Daily Active Users</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">Monthly Active Users</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">User Growth</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                  </div>
                </div>
                <div class="bg-[#F3F1E7] p-4 rounded-lg">
                  <h4 class="text-sm font-medium text-[#255D8A] mb-3">Registration Stats</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">New Users (Today)</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">New Users (This Month)</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                    <div class="flex justify-between items-center">
                      <span class="text-sm text-gray-600">Total Registered Users</span>
                      <span class="text-sm font-semibold">Coming Soon</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <canvas id="userChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    let charts = {
      tourism: null,
      transport: null,
      user: null
    };

    function destroyCharts() {
      Object.values(charts).forEach(chart => {
        if (chart) chart.destroy();
      });
      charts = {
        tourism: null,
        transport: null,
        user: null
      };
    }

    async function initCharts() {
      try {
        const period = document.getElementById('reportPeriod').value;
        document.getElementById('periodDisplay').textContent = period;
        
        // Update all loading states
        document.querySelectorAll('#popularSpot, #totalVisitors, #popularRoute, #popularTransport').forEach(el => {
          el.textContent = 'Loading...';
        });
        
        const response = await fetch(`../../tripko-backend/api/reports/get_reports.php?period=${period}`, {
          method: 'GET',
          credentials: 'include'
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Report Data:', data);

        // Update tourism statistics
        document.getElementById('popularSpot').textContent = data.tourism?.popularSpot || 'No data';
        document.getElementById('popularSpotLocation').textContent = data.tourism?.popularSpotLocation || '';
        document.getElementById('totalVisitors').textContent = (data.tourism?.totalVisitors || 0).toLocaleString();
        
        const trend = data.tourism?.visitorTrend ?? 0;
        document.getElementById('visitorsTrend').innerHTML = trend !== 0 ? `
          <span class="${trend >= 0 ? 'text-green-600' : 'text-red-600'}">
            ${trend >= 0 ? '↑' : '↓'} ${Math.abs(trend).toFixed(1)}%
          </span> vs previous period
        ` : 'No trend data';

        // Update transport statistics
        document.getElementById('popularRoute').textContent = data.transport?.popularRoute?.name || 'No data';
        document.getElementById('routeDetails').textContent = 
          data.transport?.popularRoute?.fromTown && data.transport?.popularRoute?.toTown
            ? `${data.transport.popularRoute.fromTown} → ${data.transport.popularRoute.toTown}`
            : '';

        const mostUsedTransport = data.transport?.typeDistribution?.[0];
        if (mostUsedTransport) {
          document.getElementById('popularTransport').textContent = mostUsedTransport.type;
          const totalRoutes = data.transport.typeDistribution.reduce((sum, t) => sum + t.count, 0);
          const percentage = ((mostUsedTransport.count / totalRoutes) * 100).toFixed(1);
          document.getElementById('transportPercent').textContent = `${percentage}% of all routes`;
        } else {
          document.getElementById('popularTransport').textContent = 'No data';
          document.getElementById('transportPercent').textContent = '';
        }

        // Clear existing charts
        destroyCharts();

        // Tourism Chart
        const tourismCtx = document.getElementById('tourismChart').getContext('2d');
        const tourismData = data.tourism?.monthlyData || [];
        
        const gradientFill = tourismCtx.createLinearGradient(0, 0, 0, 400);
        gradientFill.addColorStop(0, 'rgba(37, 93, 138, 0.3)');
        gradientFill.addColorStop(1, 'rgba(37, 93, 138, 0.02)');
        
        charts.tourism = new Chart(tourismCtx, {
          type: 'line',
          data: {
            labels: tourismData.map(d => {
              const [year, month] = d.month.split('-');
              return new Date(year, month - 1).toLocaleDateString('en-US', { 
                month: 'short',
                year: '2-digit'
              });
            }),
            datasets: [{
              label: 'Monthly Visitors',
              data: tourismData.map(d => d.count),
              borderColor: '#255D8A',
              backgroundColor: gradientFill,
              tension: 0.3,
              fill: true,
              pointBackgroundColor: '#255D8A',
              pointRadius: 4,
              pointHoverRadius: 6
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              intersect: false,
              mode: 'index'
            },
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#255D8A',
                titleFont: { weight: '600' },
                bodyColor: '#666',
                bodyFont: { size: 13 },
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12,
                displayColors: false,
                callbacks: {
                  label: (context) => `Visitors: ${context.parsed.y.toLocaleString()}`
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: { 
                  callback: value => value.toLocaleString(),
                  font: { size: 11 }
                },
                grid: {
                  color: 'rgba(0, 0, 0, 0.05)'
                }
              },
              x: {
                ticks: { 
                  font: { size: 11 }
                },
                grid: {
                  display: false
                }
              }
            }
          }
        });

        // Transport Chart
        const transportCtx = document.getElementById('transportChart').getContext('2d');
        const transportData = data.transport?.typeDistribution || [];
        
        charts.transport = new Chart(transportCtx, {
          type: 'doughnut',
          data: {
            labels: transportData.map(d => d.type),
            datasets: [{
              data: transportData.map(d => d.count),
              backgroundColor: [
                '#255D8A',
                '#37799E',
                '#4A96B2',
                '#5DB3C6',
                '#70D0DA'
              ]
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
              legend: { 
                position: 'bottom',
                labels: { 
                  font: { size: 11 },
                  padding: 20,
                  generateLabels: (chart) => {
                    const data = chart.data;
                    const total = data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                    return data.labels.map((label, i) => ({
                      text: `${label} (${data.datasets[0].data[i]} routes, ${Math.round((data.datasets[0].data[i]/total)*100)}%)`,
                      fillStyle: chart.data.datasets[0].backgroundColor[i],
                      index: i
                    }));
                  }
                }
              },
              tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#255D8A',
                titleFont: { weight: '600' },
                bodyColor: '#666',
                bodyFont: { size: 13 },
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                  label: (context) => {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = total > 0 ? Math.round((context.parsed/total)*100) : 0;
                    return `${context.label}: ${context.parsed} routes (${percentage}%)`;
                  }
                }
              }
            }
          }
        });

      } catch (error) {
        console.error('Chart initialization error:', error);
        document.querySelectorAll('#popularSpot, #totalVisitors, #popularRoute, #popularTransport').forEach(el => {
          el.textContent = 'Error loading data';
        });
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      initCharts();
      
      // Reload data when period changes
      document.getElementById('reportPeriod').addEventListener('change', (e) => {
        initCharts();
      });

      function toggleTransportDropdown(event) {
    event.preventDefault();
    const dropdown = document.getElementById('transportDropdown');
    const icon = document.getElementById('transportDropdownIcon');
    
    dropdown.classList.toggle('hidden');
    icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(180deg)' : 'rotate(0deg)';
}

    function toggleTransportDropdown(event) {
      event.preventDefault();
      const dropdown = document.getElementById('transportDropdown');
      const icon = document.getElementById('transportDropdownIcon');
      dropdown.classList.toggle('hidden');
      icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }
  </script>
</body>
</html>