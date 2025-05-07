<?php
require_once('../../tripko-backend/config/check_session.php');
checkAdminSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TripKo Pangasinan - Tourist Spots</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
        <a href="dashboard.php" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 rounded-lg transition-colors group">
          <i class="fas fa-home w-6"></i>
          <span class="ml-3">Dashboard</span>
        </a>

        <!-- Tourism Section -->
        <div class="mt-6">
          <p class="px-4 text-xs font-semibold text-blue-300 uppercase">Tourism</p>
          <div class="mt-3 space-y-2">
            <a href="tourist_spot.php" class="flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg transition-colors group">
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
          <span>Tourist Spots</span>
        </div>
        <div class="flex items-center gap-4">
          <div>
            <input type="search" placeholder="Search" class="w-48 md:w-64 rounded-full border border-gray-400 bg-[#F3F1E7] py-1.5 px-4 text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#255D8A]" />
          </div>
          <button aria-label="Notifications" class="text-black text-xl focus:outline-none">
            <i class="fas fa-bell"></i>
          </button>
        </div>
      </header>

      <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl">Tourist Spots</h2>
        <div class="flex gap-3">
          <button onclick="openModal()" class="bg-[#255D8A] text-white px-4 py-2 rounded-md hover:bg-[#1e4d70] transition-colors">
            + Add new spot
          </button>
          <button onclick="toggleView()" id="viewToggleBtn" class="bg-[#255D8A] text-white px-4 py-2 rounded-md hover:bg-[#1e4d70] transition-colors">
            <i class="fas fa-table"></i> Table View
          </button>
          <div class="relative">
            <select id="municipalityFilter" onchange="filterTouristSpots()" class="bg-[#255D8A] text-white px-4 py-2 rounded-md hover:bg-[#1e4d70] transition-colors cursor-pointer">
              <option value="">All Municipalities</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tourist spots grid -->
      <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tourist spot cards will be dynamically added here -->
      </div>

      <!-- Tourist spots table -->
      <div id="tableView" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <table class="w-full border-collapse">
            <thead class="bg-gray-50">
              <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Category</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Municipality</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Contact Info</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="spotTableBody">
              <!-- Tourist spot rows will be dynamically added here -->
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Add New Spot Modal -->
  <div id="addSpotModal" class="fixed inset-0 hidden">
    <div class="modal-overlay"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div class="form-container">
        <button type="button" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700" onclick="closeModal()">
          <i class="fas fa-times text-xl"></i>
        </button>
        
        <h2 class="form-title">Add New Tourist Spot</h2>
        
        <form enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label>Tourist Spot Name <span class="required">*</span></label>
              <input type="text" name="name" required class="form-control">
            </div>
            <div class="form-group">
              <label>Category <span class="required">*</span></label>
              <select name="category" required class="form-control">
                <option value="" selected disabled>Select category</option>
                <option value="Beach">Beach</option>
                <option value="Islands">Islands</option>
                <option value="Waterfalls">Waterfalls</option>
                <option value="Caves">Caves</option>
                <option value="Churches">Churches and Cathedrals</option>
                <option value="Festivals">Festivals</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Description <span class="required">*</span></label>
            <textarea name="description" rows="4" required class="form-control"></textarea>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Municipality <span class="required">*</span></label>
              <select name="town_id" id="townSelect" required class="form-control">
                <option value="" selected disabled>Select municipality</option>
              </select>
            </div>
            <div class="form-group">
              <label>Contact Info <span class="optional">(Optional)</span></label>
              <input type="text" name="contact_info" class="form-control">
            </div>
          </div>

          <div class="form-group mb-6">
            <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-[#255D8A] transition-colors">
              <i class="fas fa-cloud-upload-alt text-3xl text-[#255D8A] mb-2"></i>
              <p class="text-sm font-medium mb-1">Upload Images</p>
              <span class="text-xs text-gray-500">PNG, JPG or JPEG (max. 5MB each)</span>
              <input type="file" name="images[]" accept="image/png, image/jpeg" multiple class="hidden" />
              <div class="image-preview mt-4 grid grid-cols-4 gap-2"></div>
            </div>
          </div>

          <div class="form-buttons">
            <button type="button" class="btn btn-secondary px-4 py-2 rounded bg-gray-300" onclick="closeModal()">Cancel</button>
            <button type="submit" class="btn btn-primary px-4 py-2 rounded bg-[#28a745] text-white">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Status Change Modal -->
  <div id="statusModal" class="fixed inset-0 hidden">
    <div class="modal-overlay"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Update Tourist Spot Status</h3>
        <p class="mb-4">Current status: <span id="currentStatusText" class="font-semibold"></span></p>
        <div class="flex gap-4">
          <button onclick="updateSpotStatus('active')" 
                  class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Set Active
          </button>
          <button onclick="updateSpotStatus('inactive')" 
                  class="flex-1 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Set Inactive
          </button>
        </div>
        <button onclick="closeStatusModal()" 
                class="mt-4 w-full border border-gray-300 px-4 py-2 rounded hover:bg-gray-50">
          Cancel
        </button>
      </div>
    </div>
  </div>

  <script>
    // Modal functionality and form handling
    const modal = document.getElementById('addSpotModal');
    const form = document.querySelector('form');
    const fileInput = document.querySelector('input[type="file"]');
    const uploadArea = document.querySelector('.upload-area');

    function openModal() {
      modal.classList.remove('hidden');
      
      // Remove any existing spot_id input to ensure we're in create mode
      const existingSpotId = form.querySelector('input[name="spot_id"]');
      if (existingSpotId) {
        existingSpotId.remove();
      }
      
      // Reset form and clear preview
      form.reset();
      const preview = uploadArea.querySelector('.image-preview');
      if (preview) preview.remove();
    }

    function closeModal() {
      modal.classList.add('hidden');
    }

    // Form submission handler - handles both create and edit
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);
      const files = fileInput.files;
      
      // Only append files if new ones were selected
      if (files.length > 0) {
        for(let i = 0; i < files.length; i++) {
          formData.append('images[]', files[i]);
        }
      }

      // Determine if this is an edit or create based on presence of spot_id
      const isEdit = formData.has('spot_id');
      const url = isEdit ? 
        '../../tripko-backend/api/tourist_spot/update.php' : 
        '../../tripko-backend/api/tourist_spot/create.php';

      try {
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });

        const data = await response.json();
        if(data.success) {
          alert(isEdit ? 'Tourist spot updated successfully!' : 'Tourist spot added successfully!');
          closeModal();
          loadTouristSpots();
        } else {
          throw new Error(data.message || `Failed to ${isEdit ? 'update' : 'save'} tourist spot`);
        }
      } catch (error) {
        console.error(isEdit ? 'Update error:' : 'Save error:', error);
        alert('Error: ' + error.message);
      }
    });

    // Transport dropdown toggle
    function toggleTransportDropdown(event) {
      event.preventDefault();
      const dropdown = document.getElementById('transportDropdown');
      const icon = document.getElementById('transportDropdownIcon');
      dropdown.classList.toggle('hidden');
      icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    // File upload handling
    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
      const files = Array.from(e.target.files);
      const preview = document.createElement('div');
      preview.className = 'image-preview grid grid-cols-3 gap-2 mt-2';
      
      files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'w-full h-24 object-cover rounded';
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });

      const existingPreview = uploadArea.querySelector('.image-preview');
      if(existingPreview) existingPreview.remove();
      uploadArea.appendChild(preview);
    });

    // Helper functions
    function getImageUrl(imagePath) {
      if (!imagePath || imagePath === 'placeholder.jpg') {
        return 'https://placehold.co/400x300?text=No+Image';
      }
      return `/TripKo-System/uploads/${imagePath}`;
    }

    // Load and display tourist spots
    async function loadTouristSpots() {
      try {
        const response = await fetch('../../tripko-backend/api/tourist_spot/read.php');
        const data = await response.json();
        const container = document.querySelector('.grid');
        container.innerHTML = '';
        
        const selectedMunicipality = document.getElementById('municipalityFilter').value;
        
        if (data && data.records && Array.isArray(data.records) && data.records.length > 0) {
          const filteredSpots = selectedMunicipality ? 
            data.records.filter(spot => spot.town_id === selectedMunicipality) : 
            data.records;

          if (filteredSpots.length === 0) {
            container.innerHTML = `
              <div class="col-span-full text-center py-8 text-gray-500">
                <i class="fas fa-filter text-4xl mb-3 block"></i>
                <p>No tourist spots found for the selected municipality</p>
              </div>
            `;
            return;
          }

          filteredSpots.forEach(spot => {
            const statusClass = spot.status === 'inactive' ? 'bg-red-100 border-red-300' : '';
            container.innerHTML += `
                <div class="rounded-lg overflow-hidden border border-gray-200 shadow-md bg-white flex flex-col h-full transition-transform hover:scale-105 hover:shadow-lg ${statusClass}">
                  <div class="relative w-full h-48 bg-gray-100">
                    <img src="${getImageUrl(spot.image_path)}" 
                         alt="${spot.name || 'Tourist Spot'}"
                         class="w-full h-full object-cover transition-all duration-300" />
                    ${spot.status === 'inactive' ? '<div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">Inactive</div>' : ''}
                  </div>
                  <div class="flex-1 flex flex-col p-4">
                    <span class="inline-block bg-[#255D8A] text-white text-xs px-3 py-1 rounded-full font-semibold mb-2">${spot.category || 'Uncategorized'}</span>
                    <h3 class="text-lg font-bold mb-1 text-[#255D8A]">${spot.name}</h3>
                    <p class="text-sm text-gray-700 mb-2 line-clamp-3">${spot.description}</p>
                    <div class="mt-auto">
                      <p class="text-xs text-gray-500 flex items-center spot-municipality" data-town-id="${spot.town_id}">
                        <i class="fas fa-map-marker-alt mr-1"></i>${spot.town_name || 'Unknown Location'}
                      </p>
                      <p class="text-xs text-gray-500 mt-1 flex items-center">
                        <i class="fas fa-phone-alt mr-1"></i>${spot.contact_info || 'No contact info'}
                      </p>
                    </div>
                  </div>
                </div>
              `;
          });
        } else {
          container.innerHTML = `
            <div class="col-span-full text-center py-8 text-gray-500">
              <i class="fas fa-inbox text-4xl mb-3 block"></i>
              <p>No tourist spots found</p>
            </div>
          `;
        }
      } catch (error) {
        console.error('Fetch Error:', error);
        document.querySelector('.grid').innerHTML = `
          <div class="col-span-full text-center py-8 text-red-500">
            <i class="fas fa-exclamation-circle text-4xl mb-3 block"></i>
            <p>Failed to load tourist spots. Please try again later.</p>
            <p class="text-sm mt-2">Error details: ${error.message}</p>
          </div>
        `;
      }
    }

    // Load municipalities for the select dropdown
    async function loadMunicipalities() {
      try {
        const response = await fetch('../../tripko-backend/api/towns/read.php');
        const data = await response.json();
        const townSelect = document.querySelector('select[name="town_id"]');
        const municipalityFilter = document.getElementById('municipalityFilter');
        
        townSelect.innerHTML = '<option value="" selected disabled>Select municipality</option>';
        municipalityFilter.innerHTML = '<option value="">All Municipalities</option>';
        
        if (data && data.records && Array.isArray(data.records)) {
          data.records.forEach(town => {
            const option = document.createElement('option');
            option.value = town.town_id;
            option.textContent = town.name; // Changed from town_name to name to match API response
            townSelect.appendChild(option);
            
            // Add to municipality filter
            const filterOption = document.createElement('option');
            filterOption.value = town.town_id;
            filterOption.textContent = town.name;
            municipalityFilter.appendChild(filterOption);
          });
        }
      } catch (error) {
        console.error('Failed to load municipalities:', error);
        const townSelect = document.querySelector('select[name="town_id"]');
        const municipalityFilter = document.getElementById('municipalityFilter');
        
        if (townSelect) {
          townSelect.innerHTML = '<option value="" disabled>Error loading municipalities</option>';
        }
        if (municipalityFilter) {
          municipalityFilter.innerHTML = '<option value="">All Municipalities</option>';
        }
      }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
      loadTouristSpots();
      loadMunicipalities();
    });

    // Edit spot functionality
    async function editSpot(spot) {
      openModal();
      
      // Set form values
      form.name.value = spot.name || '';
      form.category.value = spot.category || '';
      form.description.value = spot.description || '';
      form.town_id.value = spot.town_id || '';
      form.contact_info.value = spot.contact_info || '';
      
      // Add spot_id to form for update
      let spotIdInput = form.querySelector('input[name="spot_id"]');
      if (!spotIdInput) {
        spotIdInput = document.createElement('input');
        spotIdInput.type = 'hidden';
        spotIdInput.name = 'spot_id';
        form.appendChild(spotIdInput);
      }
      spotIdInput.value = spot.spot_id;

      // Add existing image preview if available
      if (spot.image_path) {
        const preview = document.createElement('div');
        preview.className = 'image-preview grid grid-cols-3 gap-2 mt-2';
        const img = document.createElement('img');
        img.src = getImageUrl(spot.image_path);
        img.className = 'w-full h-24 object-cover rounded';
        preview.appendChild(img);
        
        const existingPreview = uploadArea.querySelector('.image-preview');
        if(existingPreview) existingPreview.remove();
        uploadArea.appendChild(preview);
      }
    }

    // Delete spot functionality
    async function deleteSpot(spotId, spotName) {
      if (confirm(`Are you sure you want to delete the tourist spot "${spotName}"?`)) {
        try {
          const response = await fetch(`../../tripko-backend/api/tourist_spot/delete.php?spot_id=${spotId}`, {
            method: 'DELETE'
          });
          const data = await response.json();
          if (data.success) {
            alert('Tourist spot deleted successfully!');
            loadTouristSpots();
          } else {
            throw new Error(data.message || 'Failed to delete tourist spot');
          }
        } catch (error) {
          console.error('Delete error:', error);
          alert('Error: ' + error.message);
        }
      }
    }

    let currentSpotId = null;

    function openStatusModal(spotId, currentStatus) {
      currentSpotId = spotId;
      const modal = document.getElementById('statusModal');
      const statusText = document.getElementById('currentStatusText');
      statusText.textContent = currentStatus || 'active';
      statusText.className = 'font-semibold ' + 
        (currentStatus === 'inactive' ? 'text-red-600' : 'text-green-600');
      modal.classList.remove('hidden');
    }

    function closeStatusModal() {
      document.getElementById('statusModal').classList.add('hidden');
      currentSpotId = null;
    }

    async function updateSpotStatus(newStatus) {
      if (!currentSpotId) return;

      try {
        const response = await fetch('../../tripko-backend/api/tourist_spot/update_status.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            spot_id: currentSpotId,
            status: newStatus
          })
        });
        
        const data = await response.json();
        if (data.success) {
          alert(`Tourist spot status updated to ${newStatus}`);
          closeStatusModal();
          // Refresh both views
          loadTouristSpots();
          if (!document.getElementById('tableView').classList.contains('hidden')) {
            loadTableView();
          }
        } else {
          throw new Error(data.message || 'Failed to update status');
        }
      } catch (error) {
        console.error('Error updating status:', error);
        alert('Failed to update tourist spot status: ' + error.message);
      }
    }

    // Update the existing toggleSpotStatus function to use the modal
    function toggleSpotStatus(spotId, currentStatus) {
      openStatusModal(spotId, currentStatus);
    }

    // Toggle view function
    function toggleView() {
      const gridView = document.getElementById('gridView');
      const tableView = document.getElementById('tableView');
      const viewToggleBtn = document.getElementById('viewToggleBtn');
      
      const isGridView = !gridView.classList.contains('hidden');
      
      gridView.classList.toggle('hidden', isGridView);
      tableView.classList.toggle('hidden', !isGridView);
      viewToggleBtn.innerHTML = isGridView ? '<i class="fas fa-th"></i> Grid View' : '<i class="fas fa-table"></i> Table View';
      
      if (!isGridView) {
        loadTableView(); // Load table data
      } else {
        loadTouristSpots(); // Load grid data
      }
    }

    // Load table view data
    async function loadTableView() {
      try {
        const response = await fetch('../../tripko-backend/api/tourist_spot/read.php');
        const data = await response.json();
        const tableBody = document.getElementById('spotTableBody');
        tableBody.innerHTML = '';
        
        if (data && data.records && Array.isArray(data.records)) {
          data.records.forEach(spot => {
            const statusClass = spot.status === 'inactive' ? 'bg-red-50' : '';
            tableBody.innerHTML += `
              <tr class="hover:bg-gray-100 transition-colors ${statusClass}">
                <td class="border border-gray-300 px-4 py-2">${spot.name}</td>
                <td class="border border-gray-300 px-4 py-2">${spot.category || 'N/A'}</td>
                <td class="border border-gray-300 px-4 py-2">${spot.town_name || 'N/A'}</td>
                <td class="border border-gray-300 px-4 py-2">${spot.contact_info || 'N/A'}</td>
                <td class="border border-gray-300 px-4 py-2 line-clamp-2">${spot.description}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                  <span class="inline-block px-2 py-1 text-xs rounded-full ${
                    spot.status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                  }">${spot.status || 'active'}</span>
                </td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                  <div class="flex justify-center gap-2">
                    <button onclick='editSpot(${JSON.stringify(spot).replace(/'/g, "&#39;")})' 
                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                      Edit
                    </button>
                    <button onclick="deleteSpot(${spot.spot_id}, '${spot.name}')" 
                            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                      Delete
                    </button>
                    <button onclick="openStatusModal(${spot.spot_id}, '${spot.status || 'active'}')"
                            class="${spot.status === 'inactive' ? 'bg-red-600' : 'bg-green-600'} text-white px-3 py-1 rounded text-sm hover:bg-opacity-90">
                      Status
                    </button>
                  </div>
                </td>
              </tr>
            `;
          });
        } else {
          tableBody.innerHTML = `
            <tr>
              <td colspan="7" class="text-center py-8">
                <div class="flex flex-col items-center justify-center text-gray-500">
                  <i class="fas fa-inbox text-4xl mb-3"></i>
                  <p>No tourist spots found</p>
                </div>
              </td>
            </tr>
          `;
        }
      } catch (error) {
        console.error('Fetch Error:', error);
        document.getElementById('spotTableBody').innerHTML = `
          <tr>
            <td colspan="7" class="text-center py-8">
              <div class="flex flex-col items-center justify-center text-red-500">
                <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                <p>Failed to load tourist spots</p>
                <p class="text-sm mt-2">Please try again later</p>
              </div>
            </td>
          </tr>
        `;
      }
    }

    // Filter tourist spots by municipality
    function filterTouristSpots() {
      const selectedMunicipality = document.getElementById('municipalityFilter').value;
      const gridView = document.getElementById('gridView');
      const tableView = document.getElementById('tableView');
      
      // Reload the tourist spots with the filter
      loadTouristSpots();
      
      // If we're in table view, reload that too
      if (!tableView.classList.contains('hidden')) {
        loadTableView();
      }
    }
  </script>
</body>
</html>