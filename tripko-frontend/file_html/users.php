<?php
require_once('../../tripko-backend/config/check_session.php');
checkAdminSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TripKo Pangasinan - Users Management</title>
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
            <a href="users.php" class="flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg transition-colors group">
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
          <span>User Management</span>
        </div>
        <div class="flex items-center gap-4">
          <div>
            <input type="search" placeholder="Search users" class="w-48 md:w-64 rounded-full border border-gray-400 bg-[#F3F1E7] py-1.5 px-4 text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#255D8A]" />
          </div>
          <button aria-label="Notifications" class="text-black text-xl focus:outline-none">
            <i class="fas fa-bell"></i>
          </button>
        </div>
      </header>

      <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl">User Accounts</h2>
        <div class="flex gap-3">
          <button onclick="openModal()" class="bg-[#255D8A] text-white px-4 py-2 rounded-md hover:bg-[#1e4d70] transition-colors">
            + Add new user
          </button>
        </div>
      </div>

      <!-- Users table -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full table-auto">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
            <!-- User rows will be dynamically added here -->
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Add/Edit User Modal -->
  <div id="userModal" class="fixed inset-0 hidden">
    <div class="modal-overlay"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div class="form-container">
        <button type="button" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700" onclick="closeModal()">
          <i class="fas fa-times text-xl"></i>
        </button>
        
        <h2 class="form-title" id="modalTitle">Add New User</h2>
        
        <form id="userForm" enctype="multipart/form-data">
          <!-- Account Information -->
          <div class="form-group">
            <h3 class="text-lg font-medium mb-3">Account Information</h3>
            <div class="space-y-3">
              <div class="form-group">
                <label>Username <span class="required">*</span></label>
                <input type="text" name="username" required class="form-control">
              </div>
              
              <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" required class="form-control">
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label>User Type <span class="required">*</span></label>
                  <select name="user_type" required class="form-control">
                    <option value="" disabled selected>Select user type</option>
                    <option value="1">Admin</option>
                    <option value="2">Regular User</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label>Status <span class="required">*</span></label>
                  <select name="status" required class="form-control">
                    <option value="" disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Profile Information -->
          <div class="form-group mt-6">
            <h3 class="text-lg font-medium mb-3">Profile Information</h3>
            <div class="space-y-3">
              <div class="form-row">
                <div class="form-group">
                  <label>First Name <span class="required">*</span></label>
                  <input type="text" name="first_name" required class="form-control">
                </div>
                
                <div class="form-group">
                  <label>Last Name <span class="required">*</span></label>
                  <input type="text" name="last_name" required class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="user_profile_dob" required class="form-control">
              </div>

              <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required class="form-control">
              </div>

              <div class="form-group">
                <label>Contact Number <span class="optional">(Optional)</span></label>
                <input type="tel" name="contact_number" class="form-control">
              </div>

              <div class="form-group">
                <label>Address <span class="optional">(Optional)</span></label>
                <textarea name="address" rows="2" class="form-control"></textarea>
              </div>
            </div>
          </div>

          <div class="form-buttons">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button type="submit" class="btn btn-primary px-4 py-2 rounded bg-[#28a745] text-white">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Modal functionality
    const modal = document.getElementById('userModal');
    const form = document.getElementById('userForm');

    function openModal() {
      modal.classList.remove('hidden');
      form.reset();
      document.getElementById('modalTitle').textContent = 'Add New User';
    }

    function closeModal() {
      modal.classList.add('hidden');
      form.reset();
    }

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

    // Load and display users
    async function loadUsers() {
      try {
        const response = await fetch('../../tripko-backend/api/users/read.php');
        const data = await response.json();
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';
        
        if (data.records && Array.isArray(data.records)) {
          data.records.forEach(user => {
            tbody.innerHTML += `
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">${user.username}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">${user.user_type}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                             ${user.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${user.status}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <button onclick="editUser(${user.user_id})" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button onclick="deleteUser(${user.user_id}, '${user.username}')" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            `;
          });
        } else {
          tbody.innerHTML = `
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                No users found
              </td>
            </tr>
          `;
        }
      } catch (error) {
        console.error('Error:', error);
        document.getElementById('usersTableBody').innerHTML = `
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-red-500">
              Failed to load users. Please try again later.
            </td>
          </tr>
        `;
      }
    }

    // Edit user
    async function editUser(userId) {
      try {
        const response = await fetch(`../../tripko-backend/api/users/read.php?user_id=${userId}`);
        const data = await response.json();
        const user = data.records.find(u => u.user_id === userId);
        
        if (!user) {
          throw new Error('User not found');
        }

        // Set form title
        document.getElementById('modalTitle').textContent = 'Edit User';
        
        // Set form values
        const form = document.getElementById('userForm');
        form.username.value = user.username;
        form.password.required = false; // Password not required for edit
        form.user_type.value = user.user_type_id;
        form.status.value = user.user_status_id;
        
        // Set profile information
        if (user.first_name) form.first_name.value = user.first_name;
        if (user.last_name) form.last_name.value = user.last_name;
        if (user.user_profile_dob) form.user_profile_dob.value = user.user_profile_dob;
        if (user.email) form.email.value = user.email;
        if (user.contact_number) form.contact_number.value = user.contact_number;
        
        // Add user_id to form for update
        const userIdInput = document.createElement('input');
        userIdInput.type = 'hidden';
        userIdInput.name = 'user_id';
        userIdInput.value = userId;
        form.appendChild(userIdInput);
        
        // Show modal
        openModal();
      } catch (error) {
        console.error('Edit error:', error);
        alert('Error: ' + error.message);
      }
    }

    // Form submission - Updated to handle both create and edit
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);
      const isEdit = formData.has('user_id');
      
      try {
        const url = isEdit 
          ? '../../tripko-backend/api/users/update.php'
          : '../../tripko-backend/api/users/create.php';

        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });

        const data = await response.json();
        if(data.success) {
          alert(isEdit ? 'User updated successfully!' : 'User created successfully!');
          closeModal();
          loadUsers();
        } else {
          throw new Error(data.message || `Failed to ${isEdit ? 'update' : 'create'} user`);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
      }
    });

    // Delete user
    async function deleteUser(userId, username) {
      if (confirm(`Are you sure you want to delete the user "${username}"?`)) {
        try {
          const response = await fetch(`../../tripko-backend/api/users/delete.php?user_id=${userId}`, {
            method: 'DELETE'
          });
          const data = await response.json();
          if (data.success) {
            alert('User deleted successfully!');
            loadUsers();
          } else {
            throw new Error(data.message || 'Failed to delete user');
          }
        } catch (error) {
          console.error('Delete error:', error);
          alert('Error: ' + error.message);
        }
      }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
      loadUsers();
    });
  </script>
</body>
</html>