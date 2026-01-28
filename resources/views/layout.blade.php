<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Restaurant - Chez Leo Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    @Vite(['resources/lib/animate/animate.min.css', 'resources/lib/owlcarousel/assets/owl.carousel.min.css',
    'resources/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css'])


    <!-- Template Stylesheet -->
    @vite(['resources/css/bootstrap.min.css', 'resources/css/style.css'])
</head>

<body>

    <div class=" bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="  position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-3">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Chez Leo</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <!--<a href="index.html" class="nav-item nav-link active">Home</a>
                         <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="service.html" class="nav-item nav-link">Service</a>
                        <a href="menu.html" class="nav-item nav-link">Menu</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="booking.html" class="dropdown-item">Booking</a>
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a> -->
                    </div>
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn btn-primary py-2 px-4">Overzicht</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4">Inloggen</a>
                    @endif
                </div>
            </nav>

            @yield('content')

            @yield('sidebar')

            <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Bedrijf</h4>
                            <a class="btn btn-link" href="">Over ons</a>
                            <a class="btn btn-link" href="">Contact</a>
                            <a class="btn btn-link" href="">Reserveren</a>
                            <a class="btn btn-link" href="">Privacy Policy</a>
                            <a class="btn btn-link" href="">Terms & Condition</a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                            <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Kennedylaan 6, Doetinchem</p>
                            <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+31 6 22909915</p>
                            <p class="mb-2"><i class="fa fa-envelope me-3"></i>chezleo@gmail.com</p>
                            <div class="d-flex pt-2">
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Openingstijden</h4>
                            <div style="display: flex; justify-content: start; gap: 15px">
                                <div class="w-1/2">
                                    <h5 class="text-light fw-normal">Maandag</h5>
                                    <p>Gesloten</p>
                                    <h5 class="text-light fw-normal">dinsdag</h5>
                                    <p>Gesloten</p>
                                    <h5 class="text-light fw-normal">Woensdag</h5>
                                    <p>17:00 - 22:00</p>
                                    <h5 class="text-light fw-normal">Donderdag</h5>
                                    <p>12:00 - 22:00</p>
                                </div>
                                <div class="w-fit">
                                    <h5 class="text-light fw-normal">Vrijdag</h5>
                                    <p>12:00 - 22:00</p>
                                    <h5 class="text-light fw-normal">Zaterdag</h5>
                                    <p>12:00 - 23:00</p>
                                    <h5 class="text-light fw-normal">Zondag</h5>
                                    <p>12:00 - 23:00</p>
                                </div>
                            </div>
                           
                            
                            
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Nieuwsbrief</h4>
                            <p>Meld je aan voor de nieuwsbrief.</p>
                            <div class="position-relative mx-auto" style="max-width: 400px;">
                                <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text"
                                    placeholder="Your email">
                                <button type="button"
                                    class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Aanmelden</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            @Vite(['resources/lib/wow/wow.min.js'])
            @Vite(['resources/lib/easing/easing.min.js'])
            @Vite(['resources/lib/waypoints/waypoints.min.js'])
            @Vite(['resources/lib/counterup/counterup.min.js'])
            @Vite(['resources/lib/owlcarousel/owl.carousel.min.js'])
            @Vite(['resources/lib/tempusdominus/js/moment.min.js'])
            @Vite(['resources/lib/tempusdominus/js/moment-timezone.min.js'])
            @Vite(['resources/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js'])

            <!-- Template Javascript -->
            @Vite(['resources/js/main.js'])
</body>

</html>