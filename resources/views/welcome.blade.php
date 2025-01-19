<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Consoler - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff !important;
        }

        .hero {
            background: url('https://img.freepik.com/free-photo/black-luxury-sport-car-driving-accross-forest_114579-4039.jpg?semt=ais_hybrid') no-repeat center center/cover;
            color: #fff;
            text-align: center;
            padding: 120px 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 60px 0 40px;
            font-size: 2.5rem;
        }

        .portfolio {
            padding: 20px 0 60px;
            background-color: #f9f9f9;
        }

        .portfolio .car-container {
            overflow: hidden;
            position: relative;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .portfolio .car-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .portfolio .car-image {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.8s cubic-bezier(0.2, 0.65, 0.3, 1.5);
        }

        .portfolio .car-container:hover .car-image {
            transform: scale(1.1) rotate(3deg);
        }

        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Wholesale Consoler</a>
            <div class="ml-auto">
                <a href="{{route('login')}}" class="btn btn-outline-light">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Discover Cars at Auction</h1>
        <p>Connecting you to Australia's top car auctions</p>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <h2 class="section-title">Find your Dream Car. Ride It ! Enjoy It !</h2>
            <div class="row g-4">
                <!-- Car 1 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://media.gettyimages.com/id/1307086567/photo/generic-modern-suv-car-in-concrete-garage.jpg?s=612x612&w=0&k=20&c=eh6EA4g462zfVg5a3iPwMsbNlTGZqYhZFUhcLoaLDSs=" alt="Toyota Camry" class="car-image">
                    </div>
                </div>

                <!-- Car 2 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://media.gettyimages.com/id/1443383974/photo/parked-vehicle-in-concrete-garage.jpg?s=612x612&w=0&k=20&c=wXC3wHsSp7s07JRESVInax7OISqu2jcJTkrcZfhpr0w=" alt="Ford Mustang" class="car-image">
                    </div>
                </div>

                <!-- Car 3 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://hagerty-media-prod.imgix.net/2024/12/Phantom-Front-Design-Crop.jpg?auto=format,compress&ixlib=php-3.3.0" alt="Honda Civic" class="car-image">
                    </div>
                </div>

                <!-- Car 4 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://i.pinimg.com/originals/6f/5c/8d/6f5c8dc618c5321c7610d46ae4e41e92.jpg" alt="BMW" class="car-image">
                    </div>
                </div>

                <!-- Car 5 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://hips.hearstapps.com/hmg-prod/images/2024-mercedes-amg-cle53-coupe-137-6619593f6fad7.jpg?crop=0.601xw:0.901xh;0.330xw,0.0986xh&resize=360:*" alt="Luxury Car" class="car-image">
                    </div>
                </div>

                <!-- Car 6 -->
                <div class="col-md-4">
                    <div class="car-container">
                        <img src="https://i0.wp.com/www.zeroto60times.com/wp-content/uploads/2017/08/car-review-photos.jpg?quality=99&strip=all&resize=386,282" alt="Sports Car" class="car-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Wholesale Consoler. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
