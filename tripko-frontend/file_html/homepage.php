<?php
session_start();
require_once '../../tripko-backend/check_session.php';

// Check if user is logged in and redirect admin to dashboard
if (!isLoggedIn()) {
    header("Location: SignUp_LogIn_Form.php");
    exit();
} elseif (isAdmin()) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripKo Pangasinan - Home</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background-color: rgba(37, 93, 138, 0.95);
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
        }

        .nav-content {
            max-width: 1500px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: nowrap;
            padding: 0 2rem;
            margin-right: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            white-space: nowrap;
        }

        .nav-links a:hover {
            color: #ffd700;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-btn {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #255D8A;
                flex-direction: column;
                padding: 1rem;
                text-align: center;
                gap: 0.5rem;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                width: 100%;
                padding: 0.75rem;
            }

            .menu-btn {
                display: block;
            }
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding-top: 60px;
            z-index: 1; /* Ensure it's below navbar */
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: all 1.5s ease-in-out;
            transform: scale(1.1);
        }

        .hero-background.active {
            opacity: 1;
            transform: scale(1);
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
        }

        .hero-content {
            max-width: 900px;
            width: 90%;
            padding: 2rem;
            position: relative;
            z-index: 3;
            backdrop-filter: blur(5px);
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.2);
        }

        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .search-container {
            margin: 2.5rem auto;
            max-width: 700px;
            width: 100%;
            position: relative;
            background: white;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #255D8A;
            font-size: 1.2rem;
        }

        .search-bar {
            width: 100%;
            padding: 1.2rem;
            padding-left: 3.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            color: #333;
            background: transparent;
        }

        .search-bar::placeholder {
            color: #888;
        }

        .cta-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #ffd700;
            color: #255D8A;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #e6c200;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
                padding: 0 1rem;
            }

            .search-container {
                width: 90%;
            }
        }

        /* Featured Section */
        .featured-section {
            padding: 4rem 1rem;
            background-color: #f9f9f9;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #255D8A;
        }

        .category-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            padding: 0 1rem;
        }

        .filter-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            border: 2px solid #255D8A;
            color: #255D8A;
            font-weight: 500;
            background: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #255D8A;
            color: white;
        }

        .cards-container {
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
            overflow: hidden;
            padding: 1rem;
        }

        .cards-slider {
            display: flex;
            transition: transform 0.5s ease;
            gap: 2rem;
        }

        .card {
            flex: 0 0 calc(33.333% - 1.33rem);
            min-width: calc(33.333% - 1.33rem);
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            opacity: 1;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: #255D8A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .slider-nav:hover {
            background: #1e4d70;
            transform: translateY(-50%) scale(1.1);
        }

        .slider-nav.prev {
            left: 0;
        }

        .slider-nav.next {
            right: 0;
        }

        .slider-nav.hidden {
            display: none;
        }

        @media (max-width: 1200px) {
            .card {
                flex: 0 0 calc(50% - 1rem);
                min-width: calc(50% - 1rem);
            }
        }

        @media (max-width: 768px) {
            .card {
                flex: 0 0 calc(100%);
                min-width: calc(100%);
            }
        }

        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            object-position: center;
        }

        .card-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .category-tag {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #255D8A;
            margin-bottom: 0.75rem;
        }

        .card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex: 1;
        }

        .contact-info {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            margin-bottom: 1rem;
        }

        .cta-button {
            display: inline-block;
            background-color: #255D8A;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
        }

        .cta-button:hover {
            background-color: #1e4d70;
            transform: translateY(-2px);
        }

        .main-cta-button {
            display: inline-block;
            background-color: #ffd700;
            color: #255D8A;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }

        .main-cta-button:hover {
            background-color: #ffed4a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
            }
        }

        .location-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #ffd700;
            font-size: 1.2rem;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .location-indicator i {
            font-size: 1.4rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu functionality
            const menuBtn = document.querySelector('.menu-btn');
            const navLinks = document.querySelector('.nav-links');
            
            menuBtn?.addEventListener('click', () => {
                navLinks?.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.nav-content')) {
                    navLinks?.classList.remove('active');
                }
            });

            // Background image rotation
            const backgrounds = document.querySelectorAll('.hero-background');
            const locationText = document.getElementById('currentLocation');
            let currentIndex = 0;

            // Initialize the first background
            backgrounds[0].classList.add('active');
            locationText.textContent = backgrounds[0].getAttribute('data-title');

            function rotateBackgrounds() {
                // Remove active class from current background
                backgrounds[currentIndex].classList.remove('active');
                
                // Move to next background
                currentIndex = (currentIndex + 1) % backgrounds.length;
                
                // Add active class to new background and update location
                backgrounds[currentIndex].classList.add('active');
                locationText.textContent = backgrounds[currentIndex].getAttribute('data-title');
            }

            // Start the rotation
            setInterval(rotateBackgrounds, 5000);

            // Category filtering and slider functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const allCards = document.querySelectorAll('.card');
            const slider = document.querySelector('.cards-slider');
            const prevBtn = document.querySelector('.slider-nav.prev');
            const nextBtn = document.querySelector('.slider-nav.next');
            
            let currentSlide = 0;
            const cardsPerSlide = window.innerWidth >= 1200 ? 3 : window.innerWidth >= 768 ? 2 : 1;
            const totalSlides = Math.ceil(allCards.length / cardsPerSlide);

            // Filter functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const category = button.getAttribute('data-category');
                    
                    allCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Reset slider position when filtering
                    currentSlide = 0;
                    updateSliderPosition();
                });
            });

            // Slider functionality
            function updateSliderPosition() {
                const cardWidth = allCards[0].offsetWidth;
                const gap = 32; // 2rem gap
                slider.style.transform = `translateX(-${currentSlide * (cardWidth + gap) * cardsPerSlide}px)`;
                
                // Update navigation buttons
                prevBtn.classList.toggle('hidden', currentSlide === 0);
                nextBtn.classList.toggle('hidden', currentSlide >= totalSlides - 1);
            }

            function showSliderNavigation() {
                if (allCards.length > cardsPerSlide) {
                    nextBtn.classList.remove('hidden');
                }
            }

            nextBtn.addEventListener('click', () => {
                if (currentSlide < totalSlides - 1) {
                    currentSlide++;
                    updateSliderPosition();
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentSlide > 0) {
                    currentSlide--;
                    updateSliderPosition();
                }
            });

            // Initialize slider
            showSliderNavigation();

            // Handle window resize
            window.addEventListener('resize', () => {
                currentSlide = 0;
                updateSliderPosition();
            });

            // Handle image errors
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = '../images/placeholder.jpg';
                    this.alt = 'Image not available';
                });
            });
        });

        // Spot management functions
        async function editSpot(spot) {
            window.location.href = `tourist_spot.php?edit=${spot.spot_id}`;
        }

        async function deleteSpot(spotId, spotName) {
            if (confirm(`Are you sure you want to delete the tourist spot "${spotName}"?`)) {
                try {
                    const response = await fetch(`../../tripko-backend/api/tourist_spot/delete.php?spot_id=${spotId}`, {
                        method: 'DELETE'
                    });
                    const data = await response.json();
                    if (data.success) {
                        alert('Tourist spot deleted successfully!');
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to delete tourist spot');
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Error: ' + error.message);
                }
            }
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
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <i class='bx bxs-plane-alt'></i>
                TripKo Pangasinan
            </div>
            <div class="nav-links">
                <a href="#"><i class='bx bxs-home'></i> Home</a>
                <a href="tourist_spot.php"><i class='bx bxs-map-alt'></i> Places to Go</a>
                <a href="#"><i class='bx bxs-calendar-star'></i> Things to Do</a>
                <a href="terminal-routes.html"><i class='bx bxs-bus'></i> Route Finder</a>
                <a href="#"><i class='bx bxs-book-content'></i> Directory</a>
                <a href="#"><i class='bx bxs-check-circle'></i> Tourist Spot Status</a>
                <a href="#"><i class='bx bxs-info-circle'></i> About Us</a>
                <a href="#"><i class='bx bxs-phone'></i> Contact Us</a>
                <a href="../../tripko-backend/logout.php"><i class='bx bx-log-out'></i> Logout</a>
            </div>
            <div class="menu-btn">
                <i class='bx bx-menu'></i>
            </div>
        </div>
    </nav>

    <section class="hero">
        <?php
        // Array of featured destination images
        $backgroundImages = [
            ['url' => '../images/hundred-islands.jpg', 'title' => 'Hundred Islands'],
            ['url' => '../images/patar-white-beach.jpg', 'title' => 'Patar White Beach'],
            ['url' => '../images/cathedral-joseph.jpg', 'title' => 'Cathedral of Saint Joseph'],
            ['url' => '../images/bolinao-falls.jpg', 'title' => 'Bolinao Falls'],
            ['url' => '../images/enchanted-cave.jpg', 'title' => 'Enchanted Cave'],
            ['url' => '../images/abagatanen-beach.jpg', 'title' => 'Abagatanen Beach'],
            ['url' => '../images/agno-beach.jpg', 'title' => 'Agno Beach']
        ];

        foreach ($backgroundImages as $index => $image) {
            echo '<div class="hero-background ' . ($index === 0 ? 'active' : '') . '" 
                      style="background-image: url(\'' . $image['url'] . '\')" 
                      data-title="' . $image['title'] . '"></div>';
        }
        ?>
        
        <div class="hero-content">
            <h1>Discover Pangasinan</h1>
            <p>Experience the breathtaking natural wonders, rich cultural heritage, and unforgettable adventures in the heart of Luzon.</p>
            <div class="location-indicator">
                <i class='bx bxs-map'></i>
                <span id="currentLocation">Hundred Islands</span>
            </div>
            <div class="search-container">
                <i class='bx bx-search search-icon'></i>
                <input type="text" class="search-bar" placeholder="Search destinations, activities, or places to visit...">
            </div>
            <a href="tourist_spot.php" class="cta-button">Start Your Journey</a>
        </div>
    </section>

    <section class="featured-section">
        <h2 class="section-title">Popular Destinations</h2>
        
        <div class="category-filters">
            <button class="filter-btn active" data-category="all">All</button>
            <button class="filter-btn" data-category="Beach">Beaches</button>
            <button class="filter-btn" data-category="Islands">Islands</button>
            <button class="filter-btn" data-category="Waterfalls">Waterfalls</button>
            <button class="filter-btn" data-category="Caves">Caves</button>
            <button class="filter-btn" data-category="Churches">Churches</button>
        </div>

        <div class="cards-container">
            <!-- Navigation buttons -->
            <div class="slider-nav prev hidden"><i class='bx bx-chevron-left'></i></div>
            <div class="slider-nav next hidden"><i class='bx bx-chevron-right'></i></div>
            
            <div class="cards-slider">
                <?php
                require_once '../../tripko-backend/config/Database.php';
                
                $database = new Database();
                $conn = $database->getConnection();
                
                $sql = "SELECT 
                            ts.*, 
                            t.town_name,
                            COALESCE(SUM(vt.visitor_count), 0) as total_visitors
                        FROM tourist_spots ts
                        LEFT JOIN towns t ON ts.town_id = t.town_id
                        LEFT JOIN visitors_tracking vt ON ts.spot_id = vt.spot_id
                        WHERE ts.status = 'active' OR ts.status IS NULL
                        GROUP BY ts.spot_id
                        ORDER BY total_visitors DESC
                        LIMIT 9";
                
                $result = $conn->query($sql);
                if (!$result) {
                    throw new Exception("Query failed: " . $conn->error);
                }

                while ($spot = $result->fetch_assoc()): ?>
                    <div class="card" data-category="<?php echo htmlspecialchars($spot['category']); ?>">
                        <div class="relative">
                            <img src="../../uploads/<?php echo htmlspecialchars($spot['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($spot['name']); ?>"
                                 loading="lazy"
                                 onerror="this.src='../images/placeholder.jpg'">
                        </div>
                        <div class="card-content">
                            <div class="category-tag">
                                <span class="inline-block bg-[#255D8A] text-white text-xs px-3 py-1 rounded-full font-semibold mb-2"><?php echo htmlspecialchars($spot['category']); ?></span>
                                <span class="inline-block bg-[#ffd700] text-[#255D8A] text-xs px-3 py-1 rounded-full font-semibold mb-2 ml-2"><?php echo htmlspecialchars($spot['town_name']); ?></span>
                            </div>
                            <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                            <p><?php echo htmlspecialchars($spot['description']); ?></p>
                            <div class="contact-info">
                                <?php if (!empty($spot['contact_info'])): ?>
                                    <p class="text-sm text-gray-600"><i class="fas fa-phone-alt mr-2"></i><?php echo htmlspecialchars($spot['contact_info']); ?></p>
                                <?php endif; ?>
                            </div>
                            <a href="tourist_spot.php" class="cta-button">Learn More</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="tourist_spot.php" class="main-cta-button">View All Destinations</a>
        </div>
    </section>

    <div id="transportDropdown" class="hidden pl-4 space-y-2">
        <!-- Transport options will be populated by JavaScript -->
    </div>
</body>
</html>