<?php
session_start();
require_once('../../tripko-backend/config/check_session.php');
checkAdminSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TripKo Pangasinan Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js with required dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../file_css/dashboard.css" />
  <style>
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
    canvas#tourismChart, canvas#transportChart {
      width: 100% !important;
      height: 100% !important;
    }
    canvas#transportChart {
      position: absolute !important;
      top: 0;
      left: 0;
    }
  </style>
  <script>
document.addEventListener('DOMContentLoaded', () => {
    const transportDropdown = document.getElementById('transportDropdown');
    const transportDropdownIcon = document.getElementById('transportDropdownIcon');

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#transportDropdown') && !e.target.closest('[onclick*="toggleTransportDropdown"]')) {
            transportDropdown?.classList.add('hidden');
            if (transportDropdownIcon) {
                transportDropdownIcon.style.transform = 'rotate(0deg)';
            }
        }
    });
});

function toggleTransportDropdown(event) {
    event.preventDefault();
    const dropdown = document.getElementById('transportDropdown');
    const icon = document.getElementById('transportDropdownIcon');
    dropdown.classList.toggle('hidden');
    icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
}
  </script>
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
        <a href="dashboard.php" class="flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg transition-colors group">
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
            <button onclick="toggleTransportDropdown(event)" class="w-full flex items-center justify-between px-4 py-3 text-white bg-blue-700 rounded-lg transition-colors group">
              <div class="flex items-center">
                <i class="fas fa-bus w-6"></i>
                <span class="ml-3">Transport Info</span>
              </div>
              <i class="fas fa-chevron-down text-sm transition-transform duration-200 rotate-180" id="transportDropdownIcon"></i>
            </button>
            <div id="transportDropdown" class="pl-4 space-y-2">
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
            <a href="reports.php" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
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
          <span>Dashboard Overview</span>
        </div>
        <div class="flex items-center gap-4">
          <select id="dashboardPeriod" class="rounded-full border border-gray-400 bg-[#F3F1E7] py-1.5 px-4 text-gray-600">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 3 months</option>
            <option value="365">Last year</option>
          </select>
          <button aria-label="Notifications" class="text-black text-xl focus:outline-none">
            <i class="fas fa-bell"></i>
          </button>
        </div>
      </header>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Tourism Trends -->
        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <h3 class="text-lg font-semibold mb-4">Tourism Trends</h3>
          <div class="chart-container relative">
            <canvas id="tourismChart"></canvas>
            <div id="tourismChartError" class="error-message hidden"></div>
            <div id="tourismChartLoading" class="loading-overlay">
              <div class="text-gray-500">Loading...</div>
            </div>
          </div>
        </div>

        <!-- Transportation Analytics -->
        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <h3 class="text-lg font-semibold mb-4">Transportation Distribution</h3>
          <div class="relative h-[300px] w-full">
            <canvas id="transportChart" style="z-index: 1;"></canvas>
            <div id="transportChartLoading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10 hidden">
              <div class="text-gray-500">Loading...</div>
            </div>
            <div id="transportChartError" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10 hidden">
              <div class="text-red-500"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-full">
              <i class="fas fa-users text-[#255D8A] text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-400">Total Visitors</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-700" id="totalVisitors">Loading...</h3>
          <p class="text-sm text-gray-500 mt-2" id="visitorsTrend"></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 rounded-full">
              <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-400">Popular Destination</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-700" id="popularSpot">Loading...</h3>
          <p class="text-sm text-gray-500 mt-2" id="spotVisits"></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-100 rounded-full">
              <i class="fas fa-route text-yellow-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-400">Active Routes</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-700" id="popularRoute">Loading...</h3>
          <p class="text-sm text-gray-500 mt-2" id="routeUsage"></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md stats-card">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 rounded-full">
              <i class="fas fa-user-plus text-purple-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-400">New Users</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-700" id="newUsers">Coming Soon</h3>
          <p class="text-sm text-gray-500 mt-2" id="usersTrend">User tracking not implemented</p>
        </div>
      </section>

      <!-- Recent Activities Section -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Spots -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Recent Tourist Spots</h3>
            <a href="tourist_spot.php" class="text-[#255D8A] hover:underline text-sm">View All</a>
          </div>
          <div class="space-y-4" id="recentSpots">
            Loading...
          </div>
        </div>

        <!-- Recent Routes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Recent Routes</h3>
            <a href="terminal-routes.html" class="text-[#255D8A] hover:underline text-sm">View All</a>
          </div>
          <div class="space-y-4" id="recentRoutes">
            Loading...
          </div>
        </div>

        <!-- Recent Users (Hidden until user system is implemented) -->
        <div class="bg-white p-6 rounded-lg shadow-md hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Recent Users</h3>
            <a href="#" class="text-[#255D8A] hover:underline text-sm">View All</a>
          </div>
          <div class="space-y-4" id="recentUsers">
            <div class="text-gray-500">User tracking coming soon</div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
        let charts = {
          tourism: null,
          transport: null
        };
        
        async function loadDashboardData() {
          try {
            console.log('Starting dashboard data load...');
            
            // Show loading states
            document.querySelectorAll('.loading-overlay').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
            
            ['totalVisitors', 'popularSpot', 'popularRoute'].forEach(id => {
              updateElement(id, 'Loading...');
            });
            
            ['visitorsTrend', 'spotVisits', 'routeUsage'].forEach(id => {
              updateElement(id, '');
            });

            destroyCharts();

            const period = document.getElementById('dashboardPeriod').value;
            const apiUrl = `../../tripko-backend/api/reports/get_reports.php?period=${period}`;
            console.log('Fetching from URL:', apiUrl);
            
            const response = await fetch(apiUrl, {
              method: 'GET',
              headers: {
                'Accept': 'application/json'
              }
            });
            
            console.log('Response status:', response.status);
            console.log('Response headers:', Object.fromEntries(response.headers));
            
            const responseText = await response.text();
            console.log('Raw response:', responseText);

            let data;
            try {
              data = JSON.parse(responseText);
              console.log('Parsed data:', data);
            } catch (e) {
              console.error('JSON parse error:', e);
              throw new Error(`Invalid JSON response: ${e.message}`);
            }

            if (!data.success) {
              throw new Error(data.message || 'Failed to load dashboard data');
            }

            // Clear error states
            document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));

            // Process data
            console.log('Processing tourism data:', data.tourism);
            if (data.tourism?.monthlyData?.length > 0) {
              console.log('Updating tourism chart with data:', data.tourism.monthlyData);
              updateTourismChart(data.tourism.monthlyData);
            } else {
              console.warn('No monthly tourism data available');
              const tourismContainer = document.getElementById('tourismChart')?.parentElement;
              if (tourismContainer) {
                tourismContainer.innerHTML = '<div class="flex items-center justify-center h-64 text-gray-500">No visitor data available</div>';
              }
            }

            console.log('Processing transport data:', data.transport);
            if (data.transport?.typeDistribution?.length > 0) {
              console.log('Updating transport chart with data:', data.transport.typeDistribution);
              updateTransportChart(data.transport.typeDistribution);
            } else {
              console.warn('No transport distribution data available');
              const transportContainer = document.getElementById('transportChart')?.parentElement;
              if (transportContainer) {
                transportContainer.innerHTML = '<div class="flex items-center justify-center h-64 text-gray-500">No transport data available</div>';
              }
            }

            // Update statistics cards
            console.log('Updating statistics cards');
            updateElement('totalVisitors', data.tourism?.totalVisitors?.toLocaleString() ?? '0');
            
            const trend = data.tourism?.visitorTrend ?? 0;
            updateElement('visitorsTrend', trend !== 0 ? `
              <span class="${trend >= 0 ? 'text-green-600' : 'text-red-600'}">
                ${trend >= 0 ? '↑' : '↓'} ${Math.abs(trend).toFixed(1)}%
              </span> vs previous period` : 'No trend data');

            updateElement('popularSpot', data.tourism?.popularSpot || 'No data');
            updateElement('spotVisits', data.tourism?.popularSpotLocation ? `Location: ${data.tourism.popularSpotLocation}` : '');
            
            updateElement('popularRoute', data.transport?.popularRoute?.name || 'No data');
            if (data.transport?.popularRoute?.fromTown && data.transport?.popularRoute?.toTown) {
              updateElement('routeUsage', `${data.transport.popularRoute.fromTown} → ${data.transport.popularRoute.toTown}`);
            }

            // Load recent activities
            console.log('Loading recent activities...');
            await loadRecentActivities();

          } catch (error) {
            console.error('Dashboard error:', error);
            handleDashboardError(error);
          } finally {
            console.log('Dashboard data load complete');
            document.querySelectorAll('.loading-overlay').forEach(el => el.classList.add('hidden'));
          }
        }

    function destroyCharts() {
        Object.values(charts).forEach(chart => {
          if (chart instanceof Chart) {
            chart.destroy();
          }
        });
        charts = {
          tourism: null,
          transport: null
        };
      }

      function updateTourismChart(monthlyData) {
        if (!monthlyData?.length) return;

        const ctx = document.getElementById('tourismChart')?.getContext('2d');
        if (!ctx) return;

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 93, 138, 0.3)');
        gradient.addColorStop(1, 'rgba(37, 93, 138, 0.02)');

        if (charts.tourism) {
          charts.tourism.destroy();
        }

        charts.tourism = new Chart(ctx, {
          type: 'line',
          data: {
            labels: monthlyData.map(d => {
              const [year, month] = d.month.split('-');
              return new Date(year, month - 1).toLocaleDateString('en-US', { 
                month: 'short',
                year: '2-digit'
              });
            }),
            datasets: [{
              label: 'Monthly Visitors',
              data: monthlyData.map(d => d.count),
              borderColor: '#255D8A',
              backgroundColor: gradient,
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
      }

      function updateTransportChart(typeDistribution) {
        if (!typeDistribution?.length) return;

        const transportCtx = document.getElementById('transportChart');
        if (!transportCtx) return;

        const sortedData = [...typeDistribution].sort((a, b) => b.count - a.count);

        if (charts.transport) {
          charts.transport.destroy();
        }

        charts.transport = new Chart(transportCtx, {
          type: 'doughnut',
          data: {
            labels: sortedData.map(d => d.type),
            datasets: [{
              data: sortedData.map(d => d.count),
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
                  generateLabels: function(chart) {
                    const data = chart.data;
                    if (!data.datasets.length || !data.datasets[0].data) return [];
                    const total = data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                    if (!data.labels) return [];
                    return data.labels.map((label, i) => ({
                      text: `${label} (${data.datasets[0].data[i]} routes, ${Math.round((data.datasets[0].data[i]/total)*100)}%)`,
                      fillStyle: data.datasets[0].backgroundColor[i],
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
      }

  function updateElement(id, value) {
    const element = document.getElementById(id);
    if (element) {
      element.innerHTML = value;
    }
  }

  function handleDashboardError(error) {
    // Show error messages in each component
    document.querySelectorAll('.error-message').forEach(el => {
      el.textContent = `Failed to load data: ${error.message}`;
      el.classList.remove('hidden');
    });

    // Update stats cards to show error state
    ['totalVisitors', 'popularSpot', 'popularRoute'].forEach(id => {
      updateElement(id, 'Error loading data');
    });
    ['visitorsTrend', 'spotVisits', 'routeUsage'].forEach(id => {
      updateElement(id, '');
    });

    // Clean up any partial chart data
    destroyCharts();
  }

  // Update loadRecentActivities to handle errors better
  async function loadRecentActivities() {
    try {
      ['recentSpots', 'recentRoutes'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.innerHTML = '<div class="loading-indicator">Loading...</div>';
        }
      });

      const [spotsResponse, routesResponse] = await Promise.all([
        fetch('../../tripko-backend/api/tourist_spot/read.php', {
          credentials: 'include',
          headers: { 'Accept': 'application/json' }
        }),
        fetch('../../tripko-backend/api/terminal_routes/read.php', {
          credentials: 'include',
          headers: { 'Accept': 'application/json' }
        })
      ]);

      if (!spotsResponse.ok) {
        throw new Error(`Tourist spots API error: ${spotsResponse.status}`);
      }
      if (!routesResponse.ok) {
        throw new Error(`Routes API error: ${routesResponse.status}`);
      }

      const [spotsData, routesData] = await Promise.all([
        spotsResponse.json(),
        routesResponse.json()
      ]);

      // Validate API responses
      if (!spotsData.records || !Array.isArray(spotsData.records)) {
        throw new Error('Invalid tourist spots data format');
      }
      if (!routesData.records || !Array.isArray(routesData.records)) {
        throw new Error('Invalid routes data format');
      }

      const recentSpotsElement = document.getElementById('recentSpots');
      if (recentSpotsElement) {
        const recentSpotsHtml = spotsData.records.length > 0
          ? spotsData.records
              .slice(0, 4)
              .map(spot => `
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-[#255D8A]"></i>
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-700">${spot.name || 'Unnamed Spot'}</h4>
                    <p class="text-sm text-gray-500">${spot.town_name || 'Location unavailable'}</p>
                  </div>
                </div>
              `)
              .join('')
          : '<div class="text-gray-500">No tourist spots available</div>';
        
        recentSpotsElement.innerHTML = recentSpotsHtml;
      }

      const recentRoutesElement = document.getElementById('recentRoutes');
      if (recentRoutesElement) {
        const recentRoutesHtml = routesData.records.length > 0
          ? routesData.records
              .slice(0, 4)
              .map(route => `
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-route text-[#255D8A]"></i>
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-700">${route.from_terminal || ''} → ${route.to_terminal || ''}</h4>
                    <p class="text-sm text-gray-500">${route.transportation_types || 'No transport types'}</p>
                  </div>
                </div>
              `)
              .join('')
          : '<div class="text-gray-500">No routes available</div>';
        
        recentRoutesElement.innerHTML = recentRoutesHtml;
      }

    } catch (error) {
      console.error('Error loading recent activities:', error);
      ['recentSpots', 'recentRoutes'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.innerHTML = `<div class="text-red-500">Error loading data: ${error.message}</div>`;
        }
      });
    }
  }

  // Initialize dashboard
  document.addEventListener('DOMContentLoaded', () => {
    loadDashboardData();
    
    // Handle period changes
    document.getElementById('dashboardPeriod')?.addEventListener('change', () => {
      destroyCharts();
      loadDashboardData();
    });

    // Toggle transport dropdown
    document.querySelector('[onclick="toggleTransportDropdown(event)"]')?.addEventListener('click', (event) => {
      event.preventDefault();
      const dropdown = document.getElementById('transportDropdown');
      const icon = document.getElementById('transportDropdownIcon');
      dropdown.classList.toggle('hidden');
      icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    });
  });
  </script>
</body>
</html>